@extends('frontend.layouts.app')
@section('title', 'Create Order')

@section('content')


<div class="row">
  <div class="col-xl">
    <div class="card mb-6">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Create Order</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('orders.store') }}" method="POST">
         @csrf
          <div class="mb-6">
            <label class="form-label" for="basic-default-fullname">Order Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Item name">
            @error('name')

            <span class="text-danger">{{ $message }}</span>

            @enderror
          </div>
          
          <div class="md-6">
            <label for="nameSmall" class="form-label">Assigned to</label>
            <select id="assigned_to" name="assigned_to" class="form-select">
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            </div>
          <button type="submit" class="btn btn-primary">Send</button>
        </form>
      </div>
    </div>
  </div>

</div>

@endsection