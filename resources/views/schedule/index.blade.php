@extends('layouts/base')
@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                @if (auth()->user()->role === 'Admin')
                                    <button class="btn btn-md font-16 btn-info btn-block" id="btn-new-event"><i class="mdi mdi-plus-circle-outline"></i> Assign Staff</button>
                                @endif

                                <!-- Legend Section -->
                                <div style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; margin-bottom: 20px;">
                                    <h5 style="margin-bottom: 15px;">Legend</h5>
                                    <div style="margin-bottom: 8px; display: flex; align-items: center;">
                                        <span class="bg-success" style="width: 20px; height: 20px; border-radius: 3px; display: inline-block; margin-right: 10px;"></span>
                                        <span>Dry Cleaner</span>
                                    </div>
                                    <div style="margin-bottom: 8px; display: flex; align-items: center;">
                                        <span class="bg-primary" style="width: 20px; height: 20px; border-radius: 3px; display: inline-block; margin-right: 10px;"></span>
                                        <span>Pickup & Delivery Driver</span>
                                    </div>
                                    <div style="margin-bottom: 8px; display: flex; align-items: center;">
                                        <span class="bg-info" style="width: 20px; height: 20px; border-radius: 3px; display: inline-block; margin-right: 10px;"></span>
                                        <span>Washer/Folder</span>
                                    </div>
                                    <div style="margin-bottom: 8px; display: flex; align-items: center;">
                                        <span class="bg-dark" style="width: 20px; height: 20px; border-radius: 3px; display: inline-block; margin-right: 10px;"></span>
                                        <span>Presser/Ironing</span>
                                    </div>
                                    <div style="display: flex; align-items: center;">
                                        <span class="bg-warning" style="width: 20px; height: 20px; border-radius: 3px; display: inline-block; margin-right: 10px;"></span>
                                        <span>Dryer</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-9">
                                <div class="mt-4 mt-lg-0">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assign Staff Modal -->
                <div class="modal fade" id="event-modal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="assign-staff-form" action="{{ route('schedule.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="_method" name="_method" value="POST">
                                <input type="hidden" id="event-id" name="event_id">

                                <!-- Hidden inputs for start and end time -->
                                <input type="hidden" id="hidden-start-time" name="start_time">
                                <input type="hidden" id="hidden-end-time" name="end_time">

                                <div class="modal-header py-3 px-4 border-bottom-0 d-block">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h5 class="modal-title" id="modal-title">Assign Staff</h5>
                                </div>
                                <div class="modal-body px-4 pb-4 pt-0">

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="event-staff">Staff Name</label>
                                                <select class="form-control" id="event-staff" name="staff_id" required>
                                                    <option value="">Select Staff</option>
                                                    @foreach($staff as $staffMember)
                                                        @if($staffMember->role !== 'Manager')
                                                            <option value="{{ $staffMember->id }}" data-role="{{ $staffMember->role }}">
                                                                {{ $staffMember->user->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="event-role">Role</label>
                                                <input class="form-control" type="text" id="event-role" readonly />
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="event-category">Category (Color)</label>
                                                <select class="form-control" name="category" id="event-category" required>
                                                    <option value="bg-success">Dry Cleaner</option>
                                                    <option value="bg-primary">Pickup & Delivery Driver</option>
                                                    <option value="bg-info">Washer/Folder</option>
                                                    <option value="bg-dark">Presser/Ironing</option>
                                                    <option value="bg-warning">Dryer</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="event-date">Date</label>
                                                <input class="form-control" type="date" name="date" id="event-date" required />
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="event-start-time">Start Time</label>
                                                <input class="form-control" type="time" id="event-start-time" required />
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="event-end-time">End Time</label>
                                                <input class="form-control" type="time" id="event-end-time" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-danger btn-delete-event" style="display: none;">
                                                Delete
                                            </button>                                        
                                        </div>
                                        <div class="col-6 text-right">
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success" id="btn-save-event">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            let lastViewedStaff = null; // Variable to store the last viewed staff details

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                editable: true, // Enable event dragging
                selectable: true, // Enable selecting time slots
                events: '/api/schedules', // Fetch events from the backend
                @if (auth()->user()->role === 'Admin')

                eventClick: function (info) {
                    // Open the modal with event details
                    openModalForEdit(info.event);
                },
                select: function (info) {
                    // Open modal for new event creation
                    openModalForNewEvent(info.startStr, info.endStr);
                },
                @endif
                eventDidMount: function (info) {
                    const categoryClass = info.event.extendedProps.category;
                    if (categoryClass) {
                        info.el.classList.add(categoryClass); // Set the background color class
                    }
                    info.el.style.color = 'white';
                    info.el.style.borderRadius = '5px';
                    info.el.style.textAlign = 'center'; // Center-align text
                    info.el.style.display = 'flex'; // Enable flexbox for better alignment
                    info.el.style.justifyContent = 'center'; // Center horizontally
                    info.el.style.alignItems = 'center'; // Center vertically
                    info.el.style.height = '100%'; // Ensure the element takes full height

                    const staffName = info.event.title;
                    const staffRole = info.event.extendedProps.role;
                    info.el.title = `${staffName} (${staffRole})`;
                },
            });

            calendar.render();

            document.getElementById('btn-new-event').addEventListener('click', function () {
                openModalForNewEvent(); // Open modal for new staff assignment
            });

            function openModalForEdit(event) {
                $('#event-modal').modal('show');

                // Populate the modal fields with event data
                $('#event-id').val(event.id);
                $('#event-date').val(event.startStr.split('T')[0]); // Event date
                $('#event-start-time').val(event.startStr.split('T')[1].slice(0, 5)); // Extract time (HH:mm)
                $('#event-end-time').val(event.endStr.split('T')[1].slice(0, 5)); // Extract time (HH:mm)
                $('#event-staff').val(event.extendedProps.staff_id); // Staff ID
                $('#event-category').val(event.extendedProps.category); // Category
                $('#event-role').val(event.extendedProps.role); // Staff role

                // Update hidden inputs with start and end time
                $('#hidden-start-time').val(event.startStr);
                $('#hidden-end-time').val(event.endStr);

                // Save the last viewed staff details
                lastViewedStaff = {
                    id: event.extendedProps.staff_id,
                    role: event.extendedProps.role,
                    date: event.startStr.split('T')[0],
                    startTime: event.startStr.split('T')[1],
                    endTime: event.endStr.split('T')[1],
                    category: event.extendedProps.category,
                };

                // Configure the delete button
                const deleteButton = document.querySelector('.btn-delete-event');
                deleteButton.setAttribute('data-event-id', event.id); // Set event ID
                deleteButton.style.display = 'inline-block'; // Show the button
            }

            function openModalForNewEvent(start = null, end = null) {
                $('#event-modal').modal('show');

                // Clear the modal fields
                $('#event-id').val('');
                $('#event-date').val(start ? start.split('T')[0] : ''); // Pre-fill date if available
                $('#event-start-time').val(start ? start.split('T')[1] : '09:00'); // Pre-fill start time if available
                $('#event-end-time').val(end ? end.split('T')[1] : '18:00'); // Pre-fill end time if available
                $('#event-staff').val(''); // Clear staff selection
                $('#event-category').val(''); // Clear category selection
                $('#event-role').val(''); // Clear role input

                lastViewedStaff = null; // Reset last viewed staff
                // Hide the delete button
                const deleteButton = document.querySelector('.btn-delete-event');
                deleteButton.style.display = 'none';
            }

            const staffDropdown = document.getElementById('event-staff');
            const roleInput = document.getElementById('event-role');
            staffDropdown.addEventListener('change', function () {
                const selectedOption = staffDropdown.options[staffDropdown.selectedIndex];
                const role = selectedOption.getAttribute('data-role');
                roleInput.value = role || '';
            });

            $('#event-modal').on('shown.bs.modal', function () {
                staffDropdown.dispatchEvent(new Event('change'));
            });

            const saveButton = document.querySelector('#assign-staff-form button[type="submit"]');
            const startTimeInput = document.getElementById('hidden-start-time');
            const endTimeInput = document.getElementById('hidden-end-time');
            const form = document.getElementById('assign-staff-form');

            saveButton.addEventListener('click', function (e) {
                e.preventDefault();
                const eventDate = document.getElementById('event-date').value;
                const startTime = document.getElementById('event-start-time').value;
                const endTime = document.getElementById('event-end-time').value;
                const eventId = document.getElementById('event-id').value;
                const staffName = staffDropdown.options[staffDropdown.selectedIndex].text;
                const role = roleInput.value;
                const category = document.getElementById('event-category').value;

                if (!eventDate || !startTime || !endTime) {
                    alert("Please fill in the date, start time, and end time.");
                    return;
                }

                // Confirmation prompt (user error protection)
                const confirmationMessage = `
                    Please confirm the following details before submission:

                    Staff Name: ${staffName}
                    Role: ${role}
                    Date: ${eventDate}
                    Start Time: ${startTime}
                    End Time: ${endTime}
                `;
                if (!confirm(confirmationMessage)) {
                    return; // Stop form submission if user cancels
                }

                const startDateTime = `${eventDate} ${startTime}`;
                const endDateTime = `${eventDate} ${endTime}`;

                startTimeInput.value = startDateTime;
                endTimeInput.value = endDateTime;

                const url = eventId 
                    ? `/schedule/${eventId}` // Update URL for PUT/PATCH
                    : '/schedule'; // Create URL for POST

                form.setAttribute('action', url);
                const methodField = document.getElementById('_method');
                if (eventId) {
                    methodField.value = 'PUT'; // Set method override for updating
                } else {
                    methodField.value = 'POST'; // Ensure POST method for new
                }

                // Submit the form
                form.submit();
            });

            //Delete staff details
            function deleteEvent(eventId) {
                if (confirm('Are you sure you want to delete this schedule?')) {
                    fetch(`/schedule/${eventId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                    })
                    .then(response => {
                        if (response.ok || response.status === 204) {
                            alert('Schedule deleted successfully!');
                            // Remove the event from the calendar
                            const event = calendar.getEventById(eventId);
                            if (event) event.remove();
                            $('#event-modal').modal('hide'); // Close the modal
                        } else {
                            response.json().then(data => {
                                alert(data.message || 'Failed to delete the schedule.');
                            }).catch(() => {
                                alert('Failed to delete the schedule.');
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the schedule.');
                    });
                }
            }

            // Attach event listener to delete button
            document.querySelector('.btn-delete-event').addEventListener('click', function () {
                const eventId = this.getAttribute('data-event-id');
                deleteEvent(eventId);
            });
        });

    </script>
    


@endsection
