@extends('layouts.app')

@section('content')
    @include('layouts.partials.topnav', ['title' => 'Society Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            {{-- <div class="text-end alert alert-light" role="alert">
                    <a href="{{ route('roles.create') }}" class="btn btn-sm mb-0 me-1 btn-primary">Add Role</a>
            </div> --}}
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="alert alert-light" role="alert">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6 text-start text-white">
                                    <h6 class="text-black">Society</h6>
                                </div>
                                <div class="col-lg-6 text-end">
                                    <a href="{{ route('society.create') }}" class="btn btn-sm mb-0 me-1 btn-primary">Add Society</a>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pt-6 pb-2">
                    <div class="table-responsive p-0">
                        <table id="society-datatable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SR. NO.</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Society Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phone</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Address</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">State</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">City</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pincode</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created At</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Updated At</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            
            @push('javascript')

            <script>
                $(document).ready(function() {
                    table = $('#society-datatable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('society.get-data') }}",
                            data: function(d) {
                                // Additional data if needed
                            }
                        },
                        columns: [
                            {data: 'id'},
                            {data: 'name'},
                            {data: 'phone'},
                            {data: 'address'},
                            {data: 'state'},
                            {data: 'city'},
                            {data: 'pincode'},
                            {data: 'created_at',
                                render: function(data, type, row) {
                                    var formattedDate = new Date(data).toLocaleDateString('en-GB');
                                    return '<p class="text-sm font-weight-bold mb-0 text-center">' + formattedDate + '</p>';
                                }
                            },
                            {data: 'updated_at',
                                render: function(data, type, row) {
                                    var formattedDate = new Date(data).toLocaleDateString('en-GB');
                                    return '<p class="text-sm font-weight-bold mb-0 text-center">' + formattedDate + '</p>';
                                }
                            },
                            {data: 'actions', name: 'actions', orderable: false, searchable: false}
                        ]
                    });

                    // Handle the delete action
                    $('#society-datatable').on('click', '.delete-society', function() {
                        var url = $(this).data('url');
                        if (confirm('Are you sure you want to delete this society?')) {
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if (response.success) {
                                        table.ajax.reload();
                                        alert('Society deleted successfully.');
                                    } else {
                                        alert('Error deleting role.');
                                    }
                                }
                            });
                        }
                    });

                    $('#society-datatable').on('click', '.edit-society', function() {
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
    </div>
@endsection