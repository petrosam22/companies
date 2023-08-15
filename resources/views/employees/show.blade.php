

@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
@section('content')

{{ $employee->name }}
    {{--  <td>
                        <form action="{{ route('employees.destroy', ['employee' => $employee->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('employees.edit', ['employee' => $employee->id]) }}" method="GET">
                            @csrf
                            <button class="btn btn-primary">Edit</button>
                        </form>
                    </td>  --}}

@endsection
