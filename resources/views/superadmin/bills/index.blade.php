@extends('layouts.app')
@section('title', __('Bill Ledgers'))
@section('content')
    @include('layouts.partials.topnav', ['title' => 'Bill Ledgers'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="alert alert-light" role="alert">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="text-center text-black">
                                    @foreach ($society as $company)
                                        <h3><b>{{ $company->name }}</b></h3>
                                        <h6>{{ $company->address1 }}</h6>
                                    @endforeach
                                    <p> Bills </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pt-6 pb-2">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="bill_date">Bill Date:</label>
                            <input class="form-control" type="date" id="bill_date" value="{{ date('Y-m-d') }}" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>
                        {{-- <div class="col-md-3 align-self-end mt-4">
                            <button id="search" class="btn btn-primary">Search</button>
                            <button id="clear-filters" class="btn btn-secondary">Clear Filters</button>
                        </div> --}}
                    </div>
                    <div class="table-responsive p-0">
                        <table id="bill-datatable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SR. NO.</th>
                                    <th>Name</th>
                                    <th>Alias</th>
                                    {{-- <th>Vch No.</th> --}}
                                    {{-- <th>Bill Date</th> --}}
                                    <th>Bill Amount</th>
                                    {{-- <th>Total Voucher</th> --}}
                                    {{-- <th>First Entry</th> --}}
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
                        // Function to format date to YYYY-MM-DD
                        function formatDateToInput(date) {
                            var parts = date.split("-");
                            return parts[2] + "-" + parts[1] + "-" + parts[0];
                        }

                        // Get URL parameters
                        var urlParams = new URLSearchParams(window.location.search);
                        var dateParam = urlParams.get('date');
                        if (dateParam) {
                            $('#bill_date').val(formatDateToInput(dateParam));
                        }

                        $('#bill-datatable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('bills.get-data') }}",
                                type: 'GET',
                                data: function(d) {
                                    d.guid = "{{ $societyGuid }}";
                                    d.group = "{{ $group }}";
                                    d.date = $('#bill_date').val();
                                }
                            },
                            columns: [
                                {data: 'id', name: 'id'},
                                {
                                    data: 'name',
                                    name: 'name',
                                    render: function(data, type, row, meta) {
                                        var url = "{{ route('vouchers.index') }}?ledger_guid=" + row.guid;
                                        return '<a href="' + url + '" style="color: #337ab7;">' + data + '</a>';
                                    }
                                },
                                {data: 'alias1', name: 'alias1'},
                                // {data: 'voucher_number', name: 'voucher_number'},
                                // {data: 'bill_date', name: 'bill_date'},
                                {data: 'this_year_balance', name: 'this_year_balance'},
                                // {data: 'vouchers_count', name: 'vouchers_count'},
                                // {
                                //     data: 'first_voucher_date',
                                //     name: 'first_voucher_date',
                                //     render: function(data, type, row, meta) {
                                //         return new Date(data).toISOString();
                                //     }
                                // }
                            ],
                            dom: 'Blfrtip',
                            lengthMenu: [
                                [10, 25, 50, 100, -1],
                                ['10', '25', '50', '100', 'All']
                            ],
                            buttons: [
                                {
                                    extend: 'excel',
                                    exportOptions: {
                                        columns: ':visible',
                                        modifier: {
                                            page: 'all'
                                        }
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    exportOptions: {
                                        columns: ':visible',
                                        modifier: {
                                            page: 'all'
                                        }
                                    }
                                },
                                {
                                    extend: 'print',
                                    exportOptions: {
                                        columns: ':visible',
                                        modifier: {
                                            page: 'all'
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
                            order: [[0, 'asc']],
                        });

                        $('#clear-filters').click(function () {
                            $("#name").val('').trigger('change');
                            $('#bill-datatable').DataTable().search('').draw();
                        });

                        $('#search').click(function () {
                            var url = "{{ route('bills.index') }}?date=" + formattedDate + "&guid=" + guid;
                            window.location.href = url;
                        });
                    });
                </script>
            @endpush
        </div>
    </div>
@endsection
