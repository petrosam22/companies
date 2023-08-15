@extends('layouts.app')

@section('content')
    {{--  <div class="container">  --}}
        <h2>Create Company</h2>
        <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="address">logo:</label>
                <input type="file" class="form-control" id="logo" name="logo" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('companies.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    {{--  </div>  --}}
@endsection