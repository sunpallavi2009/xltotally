@extends('layouts.app')
@section('title', __('Society Management'))
@section('content')
    @include('layouts.partials.topnav', ['title' => 'Society Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                {{-- <div class="card-header pb-0">
                    <div class="alert alert-light" role="alert">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6 text-start text-white">
                                    <h6 class="text-black">Society</h6>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div> --}}
                <div class="card-body px-4 pt-6 pb-2">
                    <div class="table-responsive p-0">
                        <table id="society-datatable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SR. NO.</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Website</th>
                                    <th>Company Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated by DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            @push('javascript')
                <script>
                    $(document).ready(function() {
                        $('#society-datatable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('society.get-data') }}",
                                type: 'GET',
                                data: function(d) {
                                    // Custom parameters can be added here if needed
                                }
                            },
                            columns: [
                                {data: 'id', name: 'id'},
                                {
                                    data: 'name',
                                    name: 'name',
                                    render: function(data, type, row, meta) {
                                        var url = "{{ route('members.index') }}?guid=" + row.guid;
                                        return '<a href="' + url + '" style="color: #337ab7;">' + data + '</a>';
                                    }
                                },
                                {data: 'address1', name: 'address1'},
                                {data: 'mobile_number', name: 'mobile_number'},
                                {data: 'website', name: 'website'},
                                {data: 'company_number', name: 'company_number'},
                            ],
                            dom: 'Bfrtip',
                            buttons: [
                                'excel', 'pdf', 'print', 'colvis',
                                {
                                    extend: 'searchBuilder',
                                    config: {
                                        columns: [0, 1, 2, 3, 4, 5]
                                    }
                                }
                            ],
                            order: [[0, 'asc']],
                        });
        
                        $('#clear-filters').click(function () {
                            $("#name").val('').trigger('change');
                            $('#society-datatable').DataTable().search('').draw();
                        });
                    });
                </script>
            @endpush
        </div>
    </div>
@endsection
