@extends('layouts.app')

@section('content')
    @include('layouts.partials.topnav', ['title' => 'Role Management'])
    <div class="row mt-4 mx-4">
        <div x-data="roles" class="col-12">
            <div class="text-end alert alert-light" role="alert">
                    <a href="{{ route('roles.create') }}" class="btn btn-sm mb-0 me-1 btn-primary">Add Role</a>
            </div>
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Roles</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table id="roles-datatable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SR. NO.</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role Name
                                    </th>
                                    {{-- <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Create Date</th> --}}
                                    {{-- <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                <img src="./img/team-1.jpg" class="avatar me-3" alt="image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Admin</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">Admin</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">22/03/2022</p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <p class="text-sm font-weight-bold mb-0">Edit</p>
                                            <p class="text-sm font-weight-bold mb-0 ps-2">Delete</p>
                                        </div>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            
            @push('javascript')

            <script>
                $(document).ready(function() {
                    table = $('#roles-datatable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('roles.get-data') }}",
                            data: function(d) {
                                // Additional data if needed
                            }
                        },
                        columns: [
                            {data: 'id'},
                            {data: 'name'},
                            // {data: 'name'},
                            // {data: 'actions', name: 'actions', orderable: false, searchable: false}
                        ]
                    });

                    // Handle the delete action
                    // $('#roles-datatable').on('click', '.delete-role', function() {
                    //     var url = $(this).data('url');
                    //     if (confirm('Are you sure you want to delete this role?')) {
                    //         $.ajax({
                    //             url: url,
                    //             type: 'DELETE',
                    //             data: {
                    //                 _token: '{{ csrf_token() }}'
                    //             },
                    //             success: function(response) {
                    //                 if (response.success) {
                    //                     table.ajax.reload();
                    //                     alert('Role deleted successfully.');
                    //                 } else {
                    //                     alert('Error deleting role.');
                    //                 }
                    //             }
                    //         });
                    //     }
                    // });

                    // $('#roles-datatable').on('click', '.edit-role', function() {
                    //     var url = $(this).data('url');
                    //     window.location.href = url;
                    // });

                    $('#clear-filters').click(function () {
                        $("#name").val('').trigger('change');
                        table.search('').draw();
                    });
                });
            </script>

            @endpush


        </div>
    </div>
@endsection



{{-- <x-app-layout>
    <div x-data="roles">

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Roles') }}
                    </h2>

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
                        <a href="{{ route('roles.create') }}">{{ __('Add Role') }}</a>
                    </h2>
                </div>
            </div>
        </header>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="text-center p-6 text-gray-900">

                        <table id="roles-datatable" class="display" style="width:100%">
                            <thead>
                            <tr>
                                <th>SR. NO.</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        @push('scripts')

        <script>
            $(document).ready(function() {
                table = $('#roles-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('roles.get-data') }}",
                        data: function(d) {
                            // Additional data if needed
                        }
                    },
                    columns: [
                        {data: 'id'},
                        {data: 'name'},
                        {data: 'actions', name: 'actions', orderable: false, searchable: false}
                    ]
                });

                // Handle the delete action
                $('#roles-datatable').on('click', '.delete-role', function() {
                    var url = $(this).data('url');
                    if (confirm('Are you sure you want to delete this role?')) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    table.ajax.reload();
                                    alert('Role deleted successfully.');
                                } else {
                                    alert('Error deleting role.');
                                }
                            }
                        });
                    }
                });

                $('#roles-datatable').on('click', '.edit-role', function() {
                    var url = $(this).data('url');
                    window.location.href = url;
                });

                $('#clear-filters').click(function () {
                    $("#name").val('').trigger('change');
                    table.search('').draw();
                });
            });
        </script>

        @endpush

    </div>
</x-app-layout> --}}

