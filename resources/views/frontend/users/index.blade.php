@extends('frontend.layouts.app')
@section('title', 'Users List')

@section('content')


<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Users</h5> 

                <form action="{{ route('users.index') }}" method="" class="d-flex align-items-center">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..." value="{{ request()->search }}" style="width: 150px;">
                    <button type="submit" class="btn btn-primary btn-sm ms-2">
                        <i class="bx bx-search"></i>
                    </button>
                </form>

                <form action="{{ route('users.index') }}" method="GET" class="d-flex align-items-center">
                    <label for="orderFilter" class="form-label mb-0">Filter by Order Count:</label>
                    <div class="form-check ms-3">
                        <input class="form-check-input" type="radio" name="order_count" value="no_orders" {{ request()->order_count == 'no_orders' ? 'checked' : '' }} />
                        <label class="form-check-label" for="zeroOrders">Zero Orders</label>
                    </div>

                    <!-- Radio Button for 1 Order -->
                    <div class="form-check ms-3">
                        <input class="form-check-input" type="radio" name="order_count" value="one" {{ request()->order_count == 'one' ? 'checked' : '' }} />
                        <label class="form-check-label" for="oneOrder">1 Order</label>
                    </div>

                    <!-- Radio Button for 1+ Orders -->
                    <div class="form-check ms-3">
                        <input class="form-check-input" type="radio" name="order_count" value="greater_than_one" {{ request()->order_count == 'greater_than_one' ? 'checked' : '' }} />
                        <label class="form-check-label" for="greaterThanOne">1+ Orders</label>
                    </div>
                    <button type="submit" class="btn btn-secondary btn-sm ms-2">
                        <i class="bx bx-filter-alt"></i> Filter
                    </button>
                </form>

                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm ms-2">Reset Filter</a>

                @if (Auth::user()->can('createUser', App\Models\User::class))
                    <small class="float-end btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewUserModal">Create New</small>
                @endif
            </div>
            <div class="card-body">
                <table class="table table-hover mb-0" id="usersTable">
                    <thead class= "table table-primary">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Total Orders</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->orders->count() }}</td>
                            <td>{{ $user->created_at->format('d-m-Y')}}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item edit_user" href="#" data-bs-toggle="modal" data-bs-target="#editUserModal" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}">Edit</a></li>
                                        <li>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No related User found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-2">
                    {{ $users->links()  }}
                </div>

            </div>
        </div>
    </div>
</div>
{{-- add new user modal --}}

<div class="modal fade" id="addNewUserModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div id="validation-errors" class="alert alert-danger" style="display:none;"></div>

            <form action="" method="POST" id="new_user_form">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nameSmall" class="form-label">Name</label>
                            <input type="text"  id="name" name="name" class="form-control" placeholder="Enter Name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nameSmall" class="form-label">Email</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Enter Email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div id="error-messages">
                        </div>
                        <div class="col-md-6">
                            <label for="nameSmall" class="form-label">Password</label>
                            <input type="password" required id="password" name="password" class="form-control" placeholder="Enter Password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                      
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submit_btn">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- edit user modal--}}
<div class="modal fade" id="editUserModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div id="error-messagess">
            </div>
            <form action="" method="POST" id="edit_user_form">
                @csrf
                <input type="hidden" name="" id="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nameSmall" class="form-label">Name</label>
                            <input type="text" id="edit_name" name="name" class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="col-md-6">
                            <label for="nameSmall" class="form-label">Email</label>
                            <input type="text" id="edit_email" name="email" class="form-control" placeholder="Enter Email">
                        </div>
                       
                        <div class="col-md-6">
                            <label for="nameSmall" class="form-label">Password</label>
                            <input type="password" autocomplete=""  id="edit_password" name="edit_password" class="form-control" placeholder="Enter Password">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary update_btn">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="../assets/js/common.js"></script>

<script>
    $(document).ready(function() {

        $('#new_user_form').on('submit', function(e) {
            e.preventDefault();
            $('.submit_btn').prop('disabled', true);
            let name = $('#name').val();
            let email = $('#email').val();
            let password = $('#password').val();
            let _token = $('input[name=_token]').val();

            $.ajax({
                url: "{{ route('users.store') }}",
                type: "POST",
                data: {
                    name: name,
                    email: email,
                    password: password,
                    _token: _token
                },
                success: function(response) {
                    if(response.success=='true'){
                    location.reload();

                        $('#usersTable tbody').prepend('<tr><td>' + name + '</td><td>' + email + '</td></tr>');
                        $('#new_user_form')[0].reset();
                        $('#addNewUserModal').modal('hide');
                        toastr.success(response.message);
                        $('.submit_btn').prop('disabled', false);
                    }else{
                        console.log(response);
                        handleValidationErrors(response.data);
                        $('.submit_btn').prop('disabled', false);
                    }
                },
                error: function(response) {
                    $('.submit_btn').prop('disabled', false);
                }
            });
        });

        $(".edit_user").click(function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let name = $(this).data('name');
            let email = $(this).data('email');
           
            $('#id').val(id);
            $('#edit_name').val(name);
            $('#edit_email').val(email);
        });

        $('#edit_user_form').on('submit', function(e) {
            e.preventDefault();
            $('.update_btn').prop('disabled', true);
            let id = $('#id').val();
            let name = $('#edit_name').val();
            let email = $('#edit_email').val();
            let edit_password = $('#edit_password').val();
            let _token = $('input[name=_token]').val();

            $.ajax({
                url: "{{ route('users.update',':id') }}",
                type: "PUT",
                data: {
                    id: id,
                    name: name,
                    email: email,
                    edit_password: edit_password,
                    _token: _token
                },
                success: function(response) {
                    if(response.success=='true'){
                        $('#usersTable tbody').prepend('<tr><td>' + name + '</td><td>' + email + '</td></tr>');
                        $('#edit_user_form')[0].reset();
                        $('#editUserModal').modal('hide');
                        toastr.success(response.message);
                        $('.update_btn').prop('disabled', false);
                    }else{
                        console.log(response);
                        handleValidateUpdate(response.data);
                        $('.update_btn').prop('disabled', false);
                    }
                },
                error: function(response) {
                    $('.update_btn').prop('disabled', false);
                }
            });
        });
    });

   
</script>


@endsection