@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
@section('content')
    <div class="container">
        <h2>Employees</h2>
        <a href="{{ route('employees.create') }}" class="btn btn-primary mb-2">Create Employee</a>
        <div class="form-group">
            <label for="company">Filter by Company:</label>
            <select class="form-control" id="company" name="company">
                <option value="">All Companies</option>
                @foreach ($companies as $companyId => $companyName)
                    <option value="{{ $companyId }}">{{ $companyName }}</option>
                @endforeach
            </select>
        </div>

        <table class="table table-bordered" id="employees-table" style="
    width: 100%;
    margin: 36px 14px;
">
<thead>
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Email</th>
        <th>Edit</th>
        <th>Company</th>
        <th>Delete</th>
    </tr>
</thead>
<tbody>
    @foreach($employees as $employee)
    <tr data-employee-id="{{ $employee->id }}">
        <td>
            <img src="{{asset($employee->image )}}" style="width:100px; hieght:100px;" srcset="">
        </td>
        <td>
            <a href="{{ route('employees.show', ['employee' => $employee->id]) }}">
                {{ $employee->name }}
            </a>
        </td>
        <td>{{ $employee->email }}</td>
        <td>{!! $employee->edit !!}</td>
        <td>{{ $employee->company->name }}</td>
        <td>{!! $employee->delete !!}</td>
    </tr>
    @endforeach
</tbody>
        </table>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            var table = $('#employees-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('employees.index') }}",
                    data: function (d) {
                        d.company = $('#company').val(); // Get the selected company value
                    }
                },
                columns: [
                    { data: 'image', name: 'image' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'edit', name: 'edit' },
                    { data: 'company', name: 'company' },
                    { data: 'delete', name: 'delete' },
        

                ]


            });

            // Handle the company filter change event
            $('#company').on('change', function () {
                table.ajax.reload(); // Reload the table data when the filter changes
            });
        });
    </script>

@endsection
