@extends('layouts/base')
@section('content')
    
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="">Profile Information</h4>
                        <p class="text-muted font-13 mb-4">
                            Update your account's profile information
                        </p>
                        <form id="profileForm" method="POST" action="{{ route('profile.update') }}" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <div class="row m-2">
                                <!-- Name -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        {{-- <span id="name-display" onclick="makeEditable('name')">{{ $staff->user->name }}</span> --}}
                                        <input type="text" id="name-input" class="form-control" name="name" value="{{ $staff->user->name }}">
                                        <small id="name-error" class="text-danger"></small>
                                    </div>
                                </div>
                        
                                <!-- Phone Number -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        {{-- <span id="contact_number-display" onclick="makeEditable('contact_number')">{{ $staff->user->contact_number }}</span> --}}
                                        <input type="text" id="contact_number-input" name="contact_number" class="form-control" value="{{ $staff->user->contact_number }}">
                                        {{-- <small id="contact_number-error" class="text-danger"></small> --}}
                                    </div>
                                </div>
                        
                                <!-- Email -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        {{-- <span id="email-display" onclick="makeEditable('email')">{{ $staff->user->email }}</span> --}}
                                        <input type="email" id="email-input" name="email" class="form-control" value="{{ $staff->user->email }}" >
                                        {{-- <small id="email-error" class="text-danger"></small> --}}
                                    </div>
                                </div>
                        
                                <!-- Gender -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        {{-- <span id="gender-display" onclick="makeEditable('gender')">{{ $staff->gender }}</span> --}}
                                        <select id="gender-input" name="gender" class="form-control">
                                            <option value="Male" {{ $staff->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ $staff->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        {{-- <small id="gender-error" class="text-danger"></small> --}}
                                    </div>
                                </div>
                        
                                <!-- Role -->
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Role</label>
                                        {{-- <span id="role-display">{{ $staff->role }}</span> --}}
                                        <input type="text" id="role-input" name="role" class="form-control" value="{{ $staff->role }}" readonly>
                                    </div>
                                </div>
                        
                                <!-- Address -->
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea id="address-input" name="address" class="form-control" rows="3">{{ old('address', $staff->address) }}</textarea>
                                        @error('address')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                        
                                <div class="text-center mt-2">
                                    <button type="button" onclick="history.back()" class="btn btn-light mr-3">Back</button>
                                    <button type="submit" class="btn btn-info">Save</button>
                                </div>
                            </div>
                        </form>
                        
                    </div> <!-- end card-body-->
                </div><!-- end card-->
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>

    <script>
        // Function to toggle between edit and display mode
        function makeEditable(field) {
            const displayElement = document.getElementById(`${field}-display`);
            const inputElement = document.getElementById(`${field}-input`);
            
            // Hide the display span and show the input field
            displayElement.classList.add('d-none');
            inputElement.classList.remove('d-none');
            inputElement.focus(); // Focus the input to allow immediate editing
        }

        // Function to update field via AJAX
        function updateField(field, value) {
            const errorElement = document.getElementById(`${field}-error`);
            const data = { value: value };

            // Make an AJAX request to update the field
            fetch(`/profile/${field}/update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    // Update the display span and hide the input field
                    document.getElementById(`${field}-display`).innerText = value;
                    makeEditable(field);  // Toggle back to view mode
                } else {
                    // Show error message if any
                    errorElement.innerText = response.message || 'Something went wrong';
                }
            })
            .catch(error => {
                // Handle any errors during the request
                console.error('Error:', error);
                errorElement.innerText = 'Failed to update, please try again.';
            });
        }

    </script>

@endsection