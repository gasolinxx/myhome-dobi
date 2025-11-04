<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Staff;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Set the session flag when the schedule page is viewed
        session(['schedule_viewed' => true]);

        $staff = Staff::with('user')->get(); // Fetch all staff with their associated user
        $events = Schedule::all(); // Fetch all events (or filter as needed)

        return view('schedule.index', compact('staff', 'events'));
    }


    // Fetch schedules for the calendar
    public function getSchedules()
    {
        $user = auth()->user(); // Get the logged-in user
        $query = Schedule::with(['staff.user']); // Eager load staff and user relationships

        if ($user->role === 'Staff') {
            $staff = $user->staff; // Get the related staff record
            if (!$staff) {
                return response()->json([]); // If no staff record, return no schedules
            }

            if ($staff->role === 'Manager') {
                // Manager can see schedules for all staff roles
                $query->with('staff');
            } else {
                // Other staff can only see their own schedules
                $query->where('staff_id', $staff->id);
            }
        }

        if ($user->role === 'Admin') {
            // Admin can see all schedules
            $query->with('staff');
        }

        // Fetch and format schedules
        $schedules = $query->get();

        return response()->json($schedules->map(function ($schedule) {
            return [
                'id'       => $schedule->id,
                'title'    => $schedule->staff->user->name, // Staff name
                'start'    => $schedule->start_time, // Start time in ISO format
                'end'      => $schedule->end_time, // End time in ISO format
                'category' => $schedule->category, // Category of the schedule
                'staff_id' => $schedule->staff_id, // Staff ID
                'role'     => $schedule->staff->role, // Staff role (e.g., 'Manager', 'Dryer')
            ];
        }));
    }



    // Fetch staff to display in the dropdown
    public function getAllStaff()
    {
        $staff = Staff::with('user')->get(); // Fetch staff with user info
        return response()->json($staff);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        // Validate the input data
        $validatedData = $request->validate([
            'staff_id'   => 'required|exists:staff,id',
            'category'   => 'required|string',
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after:start_time',
        ]);

        // Check for overlapping schedules for the same staff (user error protection)
        $overlappingSchedule = Schedule::where('staff_id', $validatedData['staff_id'])
            ->where(function ($query) use ($validatedData) {
                $query->whereBetween('start_time', [$validatedData['start_time'], $validatedData['end_time']])
                    ->orWhereBetween('end_time', [$validatedData['start_time'], $validatedData['end_time']])
                    ->orWhere(function ($query) use ($validatedData) {
                        $query->where('start_time', '<=', $validatedData['start_time'])
                                ->where('end_time', '>=', $validatedData['end_time']);
                    });
            })
            ->exists();

        if ($overlappingSchedule) {
            return redirect()->back()->withErrors(['error' => 'This schedule overlaps with an existing schedule for the same staff.']);
        }

        // Create a new schedule
        Schedule::create($validatedData);

        return redirect()->route('schedule.index')->with('success', 'Schedule created successfully!');
    }




    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $staff = Staff::with('user')->findOrFail($id); // Fetch a specific staff record
        $events = Schedule::all(); // Fetch all schedules if needed
        return view('schedule.edit', compact('staff', 'events'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id); // Find the schedule by ID or fail with 404

        // Validate the input data
        $validatedData = $request->validate([
            'staff_id'   => 'required|exists:staff,id',
            'category'   => 'required|string',
            'start_time' => 'required|date_format:Y-m-d H:i',
            'end_time'   => 'required|date_format:Y-m-d H:i|after:start_time',
        ]);

        // Check for overlapping schedules for the same staff, excluding the current schedule
        $overlappingSchedule = Schedule::where('staff_id', $validatedData['staff_id'])
            ->where('id', '!=', $schedule->id) // Exclude the current schedule
            ->where(function ($query) use ($validatedData) {
                $query->whereBetween('start_time', [$validatedData['start_time'], $validatedData['end_time']])
                    ->orWhereBetween('end_time', [$validatedData['start_time'], $validatedData['end_time']])
                    ->orWhere(function ($query) use ($validatedData) {
                        $query->where('start_time', '<=', $validatedData['start_time'])
                                ->where('end_time', '>=', $validatedData['end_time']);
                    });
            })
            ->exists();

        //overlapping - user error protection
        if ($overlappingSchedule) {
            return redirect()->back()->withErrors(['error' => 'This schedule overlaps with an existing schedule for the same staff.']);
        }

        // Update the schedule
        $schedule->update($validatedData);

        return redirect()->route('schedule.index')->with('success', 'Schedule updated successfully!');
    }




    /**
     * Remove the specified resource from storage.
     */

     public function destroy($id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found.'], 404);
        }

        $schedule->delete();

        return response()->json(['message' => 'Schedule deleted successfully!'], 200);
    }


}
