@extends('frontend.layouts.app')
@section('title', 'Orders List')

@section('content')



<div class="row">
    <div class="col-12">
        <div class="card mb-4">

            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Orders</h5> 
                <form action="{{ route('orders.index') }}" method="" class="d-flex align-items-center">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..." value="{{ request()->search }}" style="width: 150px;">
                    <button type="submit" class="btn btn-primary btn-sm ms-2">
                        <i class="bx bx-search"></i>
                    </button>
                </form>


                <form action="{{ route('orders.index') }}" method="GET" class="d-flex align-items-center ms-3">
                    <div class="d-flex align-items-center">
                        <label for="userFilter" class="form-label mb-0">Filter by User:</label>
                        <select name="user_id" id="userFilter" class="form-select form-select-sm ms-2">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-secondary btn-sm ms-2">
                        <i class="bx bx-filter-alt"></i> Filter
                    </button>
                </form>

                <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm ms-2">Reset Filter</a>


                @if (Auth::user()->can('createUser', App\Models\User::class))
                    <small class="float-end btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewOrderModal">Create New</small>
                @endif

            </div>

            <div class="card-body">
                <table class="table table-hover mb-0" id="orderTable">
                    <thead class="table table-primary">
                        <tr>
                            <th scope="col">Order Name</th>
                            <th scope="col">Ordered By</th>
                            <th scope="col">Created At</th>

                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->order_name }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->created_at->format('d-m-Y')}}</td>


                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item edit_order" href="#" data-bs-toggle="modal" data-bs-target="#editOrderModal" data-id="{{ $order->id }}" data-name="{{ $order->order_name }}"  data-assigned ="{{ $order->user_id }}" >Edit</a></li>
                                        <li>
                                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
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
                            <td colspan="5" class="text-center">No related order found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-2">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>


{{-- add new order modal --}}

<div class="modal fade" id="addNewOrderModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Add New Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="new_order_form">
                @csrf
                <div class="modal-body">

                <div id="error-messages">
                </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="nameSmall" class="form-label">Order Name</label>
                            <input type="text" id="order_name" name="order_name" class="form-control" placeholder="Enter Name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nameSmall" class="form-label">Assigned to</label>
                            <select id="assigned_to" name="assigned_to" class="form-select">
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                      
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submit_btn">Create Order</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- edit order modal--}}
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Edit Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="edit_user_form">
                @csrf

                <div id="error-messagess">
                </div>
                <input type="hidden" name="" id="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nameSmall" class="form-label">Order Name</label>
                            <input type="text"  id="edit_name" name="edit_name" class="form-control" placeholder="Enter Name">
                        </div>

                        <div class="col-md-6">
                            <label for="nameSmall" class="form-label">Assigned to</label>
                            <select id="eassigned_to" name="eassigned_to" class="form-select">
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
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

        $('#new_order_form').on('submit', function(e) {
            e.preventDefault();
            $('.submit_btn').prop('disabled', true);
            let name = $('#order_name').val();
            let assigned_to = $('#assigned_to').val();

            let _token = $('input[name=_token]').val();

            $.ajax({
                url: "{{ route('orders.store') }}",
                type: "POST",
                data: {
                    name: name,
                    assigned_to: assigned_to,
                    _token: _token
                },
                success: function(response) {
                    // if (response.success) {
                    if(response.success=='true'){
                        location.reload();
                        $('#orderTable tbody').prepend('<tr><td>' + name + '</td><td>' + assigned_to + '</td></tr>');
                        $('#new_order_form')[0].reset();
                        $('#addNewOrderModal').modal('hide');
                        toastr.success(response.message);
                        $('.submit_btn').prop('disabled', false);

                    }else{
                        order_add_validation(response.data);
                        $('.submit_btn').prop('disabled', false);

                    }
                },
                error: function(response) {
                    $('.submit_btn').prop('disabled', false);
                }
            });
        });

        // edit user 

        $(".edit_order").click(function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let name = $(this).data('name');
            let assigned_to = $(this).data('assigned');
            
            $('#id').val(id);
            $('#edit_name').val(name);
            $('#eassigned_to').val(assigned_to).trigger('change'); // Trigger change event to update UI if necessary

        });

        $('#edit_user_form').on('submit', function(e) {
            e.preventDefault();

           
            $('.update_btn').prop('disabled', true);
            let id = $('#id').val();
            let name = $('#edit_name').val();
            let assigned_to = $('#eassigned_to').val();
            let _token = $('input[name=_token]').val();

            $.ajax({
                // url: "{{ route('orders.update',':id') }}",
                url: "{{ route('orders.update', ':id') }}".replace(':id', id), 

                type: "PUT",
                data: {
                    id: id,
                    name: name,
                    assigned_to: assigned_to,
                    _token: _token
                },
                success: function(response) {
                    if (response.success=='true') {
                        location.reload();
                        $('#orderTable tbody').prepend('<tr><td>' + name + '</td><td>' + assigned_to + '</td></tr>');
                        $('#edit_user_form')[0].reset();
                        $('#editOrderModal').modal('hide');
                        toastr.success(response.message);
                        $('.update_btn').prop('disabled', false);
                    }else{
                    
                            console.log(response);
                            order_update_validation(response.data);
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