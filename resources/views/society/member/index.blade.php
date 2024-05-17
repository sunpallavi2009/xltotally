@extends('layouts.society')
    
        @section('header')
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Member') }}
                </h2>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
                    <a href="{{ route('member.create') }}">{{ __('Add Member') }}</a>
                </h2>
            </div>
        </div>  
        @endsection
    
        @section('content')
        <div class="py-12">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              

                    <div class="p-6 text-gray-900">

                        <table id="member-datatable" class="display responsive" style="width:100%">
                            <thead>
                            <tr>
                                <th>SR. NO.</th>
                                <th>Member Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Alias</th>
                                <th>Balance</th>
                                <th>Total Vouchar</th>
                                <th>Society</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
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
        </div>
        @endsection


        @push('scripts')

        <script>

            var table;

            $(document).ready(function() {
                table = $('#member-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('member.get-data') }}",
                        data: function(d) {

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
                        // {data: 'status', 
                        //     render: function(data) {
                        //         console.log('Data:', data);
                        //         return `<select class="form-control status-select" data-id="${data.id}">
                        //                     <option value="Active" ${data.status === 'Active' ? 'selected' : ''}>Active</option>
                        //                     <option value="Inactive" ${data.status === 'Inactive' ? 'selected' : ''}>Inactive</option>
                        //                 </select>`;
                        //     }
                        // },

                        {data: 'status', 
                            render: function( data, type, row) {
                                console.log('Data:', row.id , row.status); // Corrected from 'id' to 'data.id'
                                return `<select class="form-control status-select" data-id="${row.id}">
                                            <option value="Active" ${row.status === 'Active' ? 'selected' : ''}>Active</option>
                                            <option value="Inactive" ${row.status === 'Inactive' ? 'selected' : ''}>Inactive</option>
                                        </select>`;
                            }
                        },


                        {data: 'created_at'},
                        {data: 'updated_at'},
                        {data: 'actions', name: 'actions', orderable: false, searchable: false}

                    ]
                });

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
                $('#member-datatable').on('click', '.delete-role', function() {
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

