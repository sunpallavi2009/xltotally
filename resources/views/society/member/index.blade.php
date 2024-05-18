@extends('layouts.society')

@section('content')
    @include('layouts.partials.societyTopnav', ['title' => 'Member Management'])
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
                                    <h6 class="text-black">Members</h6>
                                </div>
                                <div class="col-lg-6 text-end">
                                    <a href="{{ route('member.create') }}" class="btn btn-sm mb-0 me-1 btn-primary">Add Member</a>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pt-6 pb-2">
                    <div class="table-responsive p-0">
                        <table id="member-datatable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SR. NO.</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Member Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phone</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Address</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alias</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Balance</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Vouchar</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Society</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Created Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Updated Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
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
                    table = $('#member-datatable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('member.get-data') }}",
                            data: function(d) {
                                // Additional data if needed
                            }
                        },
                        columns: [
                            {data: 'id'},
                            {data: 'name'},
                            {data: 'phone'},
                            {data: 'address'},
                            {data: 'alias'},
                            {data: 'balance'},
                            {data: 'total_vouchar'},
                            {data: 'society.name', name: 'society.name'},
                            {data: 'status', 
                                render: function( data, type, row) {
                                   // console.log('Data:', row.id , row.status); // Corrected from 'id' to 'data.id'
                                    return `<select class="form-control status-select" data-id="${row.id}">
                                                <option value="Active" ${row.status === 'Active' ? 'selected' : ''}>Active</option>
                                                <option value="Inactive" ${row.status === 'Inactive' ? 'selected' : ''}>Inactive</option>
                                            </select>`;
                                }
                            },
                            {data: 'created_at',
                                render: function(data, type, row) {
                                    var formattedDate = new Date(data).toLocaleDateString('en-GB'); 
                                    return '<td class="align-middle text-center text-sm">' +
                                        '<p class="text-sm font-weight-bold mb-0">' + formattedDate + '</p>' +
                                        '</td>';
                                }
                            },
                            {data: 'updated_at',
                                render: function(data, type, row) {
                                    var formattedDate = new Date(data).toLocaleDateString('en-GB'); 
                                    return '<td class="align-middle text-center text-sm">' +
                                        '<p class="text-sm font-weight-bold mb-0">' + formattedDate + '</p>' +
                                        '</td>';
                                }
                            },
                            {data: 'actions', name: 'actions', orderable: false, searchable: false}
                        ]
                    });

                    // $('#member-datatable').on('draw.dt', function() {
                    //     $('.status-select option').each(function() {
                    //         if ($(this).val() === 'Active') {
                    //             $(this).addClass('btn btn-primary badge badge-sm bg-gradient-success');
                    //         } else if ($(this).val() === 'Inactive') {
                    //             $(this).addClass('badge badge-sm bg-gradient-secondary');
                    //         }
                    //     });
                    // });

                    
                    $('#member-datatable').on('change', '.status-select', function() {
                        var memberId = $(this).data('id');
                        var newStatus = $(this).val();

                        $.ajax({
                            url: '/member/' + memberId + '/status',
                            type: 'PUT',
                            data: {
                                _token: '{{ csrf_token() }}',
                                status: newStatus
                            },
                            success: function(response) {
                                if (response.success) {
                                    alert('Status updated successfully.');
                                    table.ajax.reload();
                                } else {
                                    alert('Error updating status.');
                                }
                            }
                        });
                    });


                    // Handle the delete action
                    $('#member-datatable').on('click', '.delete-member', function() {
                        var url = $(this).data('url');
                        if (confirm('Are you sure you want to delete this member?')) {
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if (response.success) {
                                        table.ajax.reload();
                                        alert('Member deleted successfully.');
                                    } else {
                                        alert('Error deleting member.');
                                    }
                                }
                            });
                        }
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