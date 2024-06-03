@extends('layouts.app')
@section('title', __('Member Ledgers'))
@section('content')
    @include('layouts.partials.topnav', ['title' => 'Member Ledgers'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="alert alert-light" role="alert">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="text-center text-white">
                                    <h6 class="text-black">
                                        @foreach ($society as $company)
                                            <h3><b>{{ $company->name }}</b></h3>
                                            <h6>{{ $company->address1 }}</h6>
                                        @endforeach
                                        {{-- <h6>{{ $group }}</h6> --}}
                                    </h6>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pt-6 pb-2">
                    <div class="table-responsive p-0">
                        <table id="ledger-datatable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    {{-- <th>SR. NO.</th> --}}
                                    <th>Name</th>
                                    <th>Alias</th>
                                    <th>Parent</th>
                                    <th>Primary Group</th>
                                    <th>Balance</th>
                                    <th>Total Voucher</th>
                                    <th>First Entry</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated by DataTables -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            @push('javascript')
                <script>
       $(document).ready(function() {
                        var table = $('#ledger-datatable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('members.get-data') }}",
                                type: 'GET',
                                data: function(d) {
                                    d.guid = "{{ $societyGuid }}";
                                    d.group = "{{ $group }}"; // Pass the group parameter
                                }
                            },
                            columns: [
                                // {data: 'id', name: 'id'},
                                {
                                    data: 'name',
                                    name: 'name',
                                    render: function(data, type, row, meta) {
                                        var url = "{{ route('vouchers.index') }}?ledger_guid=" + row.guid;
                                        return '<a href="' + url + '" style="color: #337ab7;">' + data + '</a>';
                                    }
                                },
                                {data: 'alias1', name: 'alias1'},
                                {data: 'parent', name: 'parent'},
                                {data: 'primary_group', name: 'primary_group'},
                                {data: 'this_year_balance', name: 'this_year_balance'},
                                {data: 'vouchers_count', name: 'vouchers_count'},
                                {
                                    data: 'first_voucher_date',
                                    name: 'first_voucher_date',
                                    render: function(data, type, row, meta) {
                                        return new Date(data).toISOString();
                                    }
                                }
                            ],
                            dom: 'Blfrtip',
                            lengthMenu: false, // Disable length menu
                            buttons: [
                                {
                                    extend: 'excel',
                                    exportOptions: {
                                        columns: ':visible',
                                        modifier: {
                                            page: 'all' // Export all pages of data
                                        }
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    exportOptions: {
                                        columns: ':visible',
                                        modifier: {
                                            page: 'all' // Export all pages of data
                                        }
                                    }
                                },
                                {
                                    extend: 'print',
                                    exportOptions: {
                                        columns: ':visible',
                                        modifier: {
                                            page: 'all' // Export all pages of data
                                        }
                                    }
                                },
                                'colvis',
                                {
                                    extend: 'searchBuilder',
                                    config: {
                                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                                    },
                                    i18n: {
                                        conditions: {
                                            date: {
                                                '=': 'Equals',
                                                '!=': 'Not equal',
                                                'before': 'Before',
                                                'after': 'After'
                                            }
                                        },
                                        date: {
                                            format: 'YYYY-MM-DD'
                                        }
                                    }
                                }
                            ],
                            paging: false, // Disable pagination
                            order: [[0, 'asc']],
                            footerCallback: function (row, data, start, end, display) {
                                var api = this.api();
                                var balanceTotal = api.column(4, { page: 'current' }).data().reduce(function (acc, val) {
                                    return acc + parseFloat(val);
                                }, 0);
                                var vouchersTotal = api.column(5, { page: 'current' }).data().reduce(function (acc, val) {
                                    return acc + parseFloat(val);
                                }, 0);

                                $(api.column(4).footer()).html(balanceTotal.toFixed(2));
                                $(api.column(5).footer()).html(vouchersTotal.toFixed(2));
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
