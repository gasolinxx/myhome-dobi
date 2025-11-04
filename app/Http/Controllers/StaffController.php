<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch staff data with their user details and order by the latest created
        $staffs = Staff::with('user')
                    ->where('role', '!=', 'Manager') // Exclude managers
                    ->latest() // Orders by created_at descending
                    ->get();   // Execute the query and retrieve data

        // Return the view with the staff data
        return view('staff.index', compact('staffs'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|in:Male,Female',
            'address' => 'required|string',
            'role' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        // Check if a staff member with the same name and role already exists
        $existingStaff = Staff::whereHas('user', function ($query) use ($validated) {
            $query->where('name', $validated['name']);
        })->where('role', $validated['role'])->first();
        
        if ($existingStaff) {
            return back()
                ->withErrors(['role' => 'A staff member with this name and role already exists.'])
                ->withInput();
        }

        // Save the user data to the users table
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'contact_number' => $validated['contact_number'],
            'role' => 'Staff', // Set role as Staff
        ]);

        // Save staff-specific details to the staff table
        $user->staff()->create([
            'gender' => $validated['gender'],
            'role' => $validated['role'],
            'address' => $validated['address'],
        ]);

        // Redirect back with a success message
        return redirect()->route('staff.index')->with('success', 'Staff created successfully.');
    }

    public function checkDuplicate(Request $request)
    {
        $exists = Staff::where('name', $request->name)
            ->where('role', $request->role)
            ->exists();

        return response()->json(['exists' => $exists]);
    }



    // public function schedule()
    // {
    //     return view('staff.schedule');
    // }


    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        // return view('staff.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'string|max:255',
            'contact_number' => 'string|max:15',
            'email' => 'email|unique:users,email,' . $staff->user->id,
            'gender' => 'in:Male,Female',
            'address' => 'string',
            'role' => 'string|nullable', // Make role nullable to handle no changes explicitly
            'password' => 'nullable|string|min:8', // Allow password to be nullable
        ]);

        // Prepare user update data
        $userData = [
            'name' => $validated['name'],
            'contact_number' => $validated['contact_number'],
            'email' => $validated['email'],
        ];

        // Update password if provided
        if (!empty($validated['password'])) {
            $userData['password'] = bcrypt($validated['password']);
        }

        // Update user info
        $staff->user->update($userData);

        // Prepare staff update data
        $staffData = [
            'gender' => $validated['gender'],
            'address' => $validated['address'],
        ];

        // Update role only if it's explicitly provided
        if (!empty($validated['role']) && $validated['role'] !== $staff->role) {
            $staffData['role'] = $validated['role'];
        }

        // Update staff info
        $staff->update($staffData);

        return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        $staff->user->delete(); // Deletes user and cascades to staff
        return redirect()->route('staff.index')->with('success', 'Staff deleted successfully.');
    }

    public function profile()
    {
        $staff = Auth::user()->staff;

        return view('profile.index', compact('staff'));
    }

    public function updateProfile(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'contact_number' => 'required|string|max:15',
                'email' => 'required|email|unique:users,email,' . Auth::id(),
                'gender' => 'required|in:Male,Female',
                'address' => 'nullable|string',  // Update this line if address is optional
            ]);
    
            $staff = Auth::user()->staff;
    
            // Update user info
            $staff->user->update([
                'name' => $validated['name'],
                'contact_number' => $validated['contact_number'],
                'email' => $validated['email'],
            ]);
    
            // Update staff info
            $staff->update([
                'gender' => $validated['gender'],
                'address' => $validated['address'],
            ]);
    
            return redirect()->route('profile')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            // Log the error or show an error message
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    

}
