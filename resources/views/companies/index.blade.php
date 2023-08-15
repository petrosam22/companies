@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Companies</h2>
        <a href="{{ route('companies.create') }}" class="btn btn-primary mb-2">Create Company</a>

     

        <table class="table table-bordered" id="companies-table">
            <thead>


                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>logo</th>
                    <th>delete</th>
                    <th>edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $companies as $company )

                <tr>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->address }}</td>
                    <td>
                        <img style="width:100px; height:100px;" src="{{ asset($company->logo) }}" alt="">
                    </td>
                    <td>
                        <form action="{{ route('companies.destroy', $company->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                        <button class="btn btn-danger">
                            Delete
                        </button>
                    </form>
                    </td>
                    <td>
                        <form action="{{ route('companies.edit', $company->id) }}" method="GET">
                            @csrf
                        <button class="btn btn-primary">
                            Edit
                        </button>
                    </form>
                    </td>
                </tr>
                @endforeach
            </tbody>



        </table>
    </div>

    <script>
        $(function () {
            $('#companies-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('companies.index') }}",
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'address', name: 'address' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

@endsection
