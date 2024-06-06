@extends('layouts.app')
@section('title', __('Member Outstanding'))
@section('content')
    @include('layouts.partials.topnav', ['title' => 'Member Outstanding'])
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
                                    <p> Member Outstanding </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pt-6 pb-2">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="from_date">From Date:</label>
                            <input class="form-control" type="date" id="from_date" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="to_date">To Date:</label>
                            <input class="form-control" type="date" id="to_date" value="{{ date('Y-m-d') }}">
                        </div>
                        {{-- <div class="col-md-3 align-self-end mt-4">
                            <button id="search" class="btn btn-primary">Search</button>
                            <button id="clear-filters" class="btn btn-secondary">Clear Filters</button>
                        </div> --}}
                    </div>
                    <div class="table-responsive p-0">
                        <table id="memberOutstanding-datatable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Alias</th>
                                    <th>Vch No.</th>
                                    <th>From Date</th>
                                    <th>Opening Bal</th>
                                    <th>Billed Amount</th>
                                    <th>Received</th>
                                    <th>Due Amt</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated by DataTables -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th colspan="3"></th>
                                    <th></th>
                                    <th></th>
                                    <th>0.00</th>
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
                        // Initialize DataTable and store the instance in a variable
                        var dataTable = $('#memberOutstanding-datatable').DataTable({
                            processing: true,
                            serverSide: true,
                            paging: false, // Disable pagination
                            ajax: {
                                url: "{{ route('memberOutstanding.get-data') }}",
                                type: 'GET',
                                data: function(d) {
                                    d.guid = "{{ $societyGuid }}";
                                    d.group = "{{ $group }}";
                                    var fromDate = $('#from_date').val();
                                    var toDate = $('#to_date').val();
                                    d.from_date = fromDate;
                                    d.to_date = toDate;
                                }
                            },
                            columns: [
                                {
                                    data: 'name',
                                    name: 'name',
                                    render: function(data, type, row, meta) {
                                        var url = "{{ route('vouchers.index') }}?ledger_guid=" + row.guid;
                                        return '<a href="' + url + '" style="color: #337ab7;">' + data + '</a>';
                                    }
                                },
                                { data: 'alias1', name: 'alias1' },
                                { data: 'voucher_number', name: 'voucher_number' },
                                {
                                    data: null,
                                    name: 'from_date',
                                    render: function(data, type, row, meta) {
                                        var fromDate = $('#from_date').val();
                                        return fromDate;
                                    }
                                },
                                { data: 'amount', name: 'amount' },
                                {
                                    data: 'this_year_balance',
                                    name: 'this_year_balance',
                                    render: function(data, type, row, meta) {
                                        return Math.abs(data).toFixed(2); // Remove the sign and format to 2 decimal places
                                    }
                                },
                                {
                                    data: null,
                                    name: 'received',
                                    render: function(data, type, row, meta) {
                                        return '0.00'; // Always display Received as 0.00
                                    }
                                },
                                {
                                    data: null,
                                    name: 'due_amt',
                                    render: function(data, type, row, meta) {
                                        var openingBal = parseFloat(Math.abs(row.this_year_balance));
                                        var billAmount = parseFloat(row.amount);
                                        if (!isNaN(openingBal) && !isNaN(billAmount)) {
                                            var due_amt = openingBal + billAmount;
                                            if (!isNaN(due_amt)) {
                                                return due_amt.toFixed(2);
                                            } else {
                                                return "N/A"; // Return "Not Available" if outstanding is not a number
                                            }
                                        } else {
                                            return "N/A";
                                        }
                                    }
                                }
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

                            footerCallback: function (row, data, start, end, display) {
                                    var api = this.api();

                                    // Calculate the total balance for the current page
                                    var OpeningBalTotal = api.column(4, { page: 'current' }).data().reduce(function (acc, val) {
                                        return acc + parseFloat(val.replace(/,/g, '') || 0);
                                    }, 0);
                                    OpeningBalTotal = Math.abs(OpeningBalTotal); // Ensure the total balance is positive

                                    // Calculate the total billed amount for the current page
                                    var BilledAmountTotal = api.column(5, { page: 'current' }).data().reduce(function (acc, val) {
                                        return acc + parseFloat(val.replace(/,/g, '') || 0);
                                    }, 0);
                                    BilledAmountTotal = Math.abs(BilledAmountTotal); // Ensure the total billed amount is positive

                                    // Calculate the total due amount for the current page
                                    var DueAmtTotal = OpeningBalTotal + BilledAmountTotal;

                                    // Format the totals and update the footer
                                    $(api.column(4).footer()).html(OpeningBalTotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                                    $(api.column(5).footer()).html(BilledAmountTotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                                    $(api.column(7).footer()).html(DueAmtTotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                                }

                        });

                        // Reload the table when date inputs change
                        $('#from_date, #to_date').on('change', function() {
                            dataTable.ajax.reload();
                        });

                        // Clear filters button
                        $('#clear-filters').click(function() {
                            $("#name").val('').trigger('change');
                            dataTable.search('').draw();
                        });

                        // Search button
                        $('#search').click(function() {
                            var fromDate = $('#from_date').val();
                            var toDate = $('#to_date').val();
                            var url = "{{ route('memberOutstanding.index') }}?from_date=" + fromDate + "&to_date=" + toDate + "&guid=" + "{{ $societyGuid }}";
                            window.location.href = url;
                        });
                    });
                </script>
            @endpush
        </div>
    </div>
@endsection
