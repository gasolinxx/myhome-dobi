@extends('layouts/base')
@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <!-- On-Screen Guidance for Admin -->
                        <div id="admin-tooltip" class="on-screen-tooltip bg-info text-white p-3 mb-3" style="display: none;">
                            <p><strong>Welcome Admin!</strong> Here you can:</p>
                            <ul>
                                <li>View staff details by clicking the <i class="mdi mdi-eye"></i> icon.</li>
                                <li>Edit staff profiles using the <i class="mdi mdi-square-edit-outline"></i> icon.</li>
                                <li>Delete staff if no longer needed using the <i class="mdi mdi-delete"></i> icon.</li>
                            </ul>
                            <button onclick="closeTooltip('admin-tooltip')" class="btn btn-sm btn-light">Got it!</button>
                        </div>
    
                        <div class="row">
                            <h4 class="header-title">Staff List</h4>
                            <a href="{{route('staff.create')}}" class="btn btn-primary btn-sm" style="position: absolute; right:2%;">+ Add
                                Staff</a>
                        </div>
                        <br>
    
                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                            <thead style="background: #F9FAFB;">
                                <tr>
                                    <th>No.</th>
                                    <th>Staff ID</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($staffs as $index => $staff)
                                    <tr>
                                        <td>{{ $index + 1 }}.</td> <!-- Use $index for row numbering -->
                                        <td>S{{ str_pad($staff->id, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $staff->user->name }}</td>
                                        <td>{{ $staff->role }}</td>
                                        <td>
                                            <!-- View -->
                                            <a href="javascript:void(0);" class="action-icon-info" data-toggle="modal"
                                            data-target="#view-staff-{{ $staff->id }}"> 
                                             <i class="mdi mdi-eye"></i>
                                            </a>
                                        
                                            <!-- Edit -->
                                            <a href="javascript:void(0);" class="action-icon-success" data-toggle="modal"
                                                data-target="#edit-staff-{{ $staff->id }}"> 
                                                <i class="mdi mdi-square-edit-outline"></i>
                                            </a>
                                        
                                            <!-- Delete -->
                                            <a href="javascript:void(0);" class="action-icon-danger" data-toggle="modal"
                                                data-target="#delete-staff-{{ $staff->id }}"> 
                                                <i class="mdi mdi-delete"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- View Modal -->
                                    <div id="view-staff-{{ $staff->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Staff Details</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Name</label>
                                                                <input type="text" name="name" value="{{ $staff->user->name }}" class="form-control" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Phone Number</label>
                                                                <input type="text" name="contact_number" value="{{ $staff->user->contact_number }}" class="form-control" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input type="email" name="email" value="{{ $staff->user->email }}" class="form-control"disabled>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Password</label>
                                                                <input type="password" value="{{ decrypt($staff->user->password) }}" class="form-control" disabled>
                                                            </div>
                                                        </div> --}}
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Gender</label>
                                                                <input type="text" value="{{ $staff->gender }}" class="form-control" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Role</label>
                                                                <input type="text" value="{{ $staff->role }}" class="form-control" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Address</label>
                                                                <textarea name="address" class="form-control" rows="3" disabled>{{ $staff->address }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        
                                    <!-- Update Modal -->
                                    <div id="edit-staff-{{ $staff->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="">Update Staff</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('staff.update', $staff->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Name</label>
                                                                    <input type="text" name="name" value="{{ $staff->user->name }}" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Phone Number</label>
                                                                    <input type="text" name="contact_number" value="{{ $staff->user->contact_number }}" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Email</label>
                                                                    <input type="email" name="email" value="{{ $staff->user->email }}" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Password</label>
                                                                    <input type="password" id="password-{{ $staff->id }}" class="form-control" placeholder="Leave empty to keep current password">
                                                                    <span class="toggle-password" onclick="togglePasswordVisibility({{ $staff->id }})" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                                                                        <i id="toggle-icon-{{ $staff->id }}" class="fa fa-eye"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Gender</label>
                                                                    <select name="gender" class="form-control">
                                                                        <option {{ $staff->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                                        <option {{ $staff->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Role</label>
                                                                    <select name="role" class="form-control">
                                                                        <option value="Dry Cleaner" {{ $staff->role == 'Dry Cleaner' ? 'selected' : '' }}>🧴 Dry Cleaner</option>
                                                                        <option value="Washer/Folder" {{ $staff->role == 'Washer/Folder' ? 'selected' : '' }}>🧺 Washer/Folder</option>
                                                                        <option value="Dryer" {{ $staff->role == 'Dryer' ? 'selected' : '' }}>🌬️ Dryer</option>
                                                                        <option value="Presser/Ironing" {{ $staff->role == 'Presser/Ironing' ? 'selected' : '' }}>👕 Presser/Ironing</option>
                                                                        <option value="Pickup & Delivery Driver" {{ $staff->role == 'Pickup & Delivery Driver' ? 'selected' : '' }}>🚛 Pickup & Delivery Driver</option>
                                                                    </select>
                                                                    <!-- Hidden field to store the current role -->
                                                                    <input type="hidden" name="current_role" value="{{ $staff->role }}">
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>Address</label>
                                                                    <textarea name="address" class="form-control" rows="3">{{ $staff->address }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        
                                    <!-- Delete Modal -->
                                    <div id="delete-staff-{{ $staff->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Confirm Deletion</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete <strong>{{ $staff->user->name }}</strong>?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('staff.destroy', $staff->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </tbody>
                        </table>
                        
                        
                    </div> <!-- end card-body-->     
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>

    <!-- JavaScript for On-Screen Guidance -->
    <script>
        // Check if the tooltip has been dismissed
        document.addEventListener('DOMContentLoaded', () => {
            const tooltipId = 'admin-tooltip';
            if (!localStorage.getItem('tooltipDismissed')) {
                document.getElementById(tooltipId).style.display = 'block';
            }
        });

        // Close the tooltip and store the dismissal state
        function closeTooltip(id) {
            document.getElementById(id).style.display = 'none';
            localStorage.setItem('tooltipDismissed', 'true');
        }

        // Tooltips for actions
        document.querySelectorAll('[data-tooltip]').forEach(item => {
            item.addEventListener('mouseover', function () {
                const tooltip = document.createElement('div');
                tooltip.className = 'custom-tooltip';
                tooltip.innerText = this.getAttribute('data-tooltip');
                document.body.appendChild(tooltip);

                const rect = this.getBoundingClientRect();
                tooltip.style.left = `${rect.left + window.scrollX}px`;
                tooltip.style.top = `${rect.top + window.scrollY - 30}px`;

                this.addEventListener('mouseout', () => {
                    document.body.removeChild(tooltip);
                });
            });
        });
    </script>

    <!-- Styles -->
    <style>
        .on-screen-tooltip {
            border-radius: 5px;
        }

        .custom-tooltip {
            position: absolute;
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            z-index: 9999;
        }
    </style>
    
@endsection
