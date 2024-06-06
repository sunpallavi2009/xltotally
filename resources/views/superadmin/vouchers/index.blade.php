@extends('layouts.app')
@section('title', __('Ledgers Management'))
@section('content')
    @include('layouts.partials.topnav', ['title' => 'Ledgers Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="alert alert-light" role="alert">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="text-center text-black">
                                    @if($society)
                                        <h3><b>{{ $society->name }}</b></h3>
                                        <h6>{{ $society->address1 }}</h6>
                                    @else
                                        <h6>No Society Information Found</h6>
                                    @endif

                                    @if($members && $members->count() > 0)
                                        @foreach ($members as $member)
                                            <div>
                                                <h6>{{ $member->name }}</h6>
                                                <h6>{{ $member->alias1 }}</h6>
                                            </div>
                                        @endforeach
                                    @else
                                        <h6>No Member Information Found</h6>
                                    @endif
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pt-6">
                    
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="from_date">From Date:</label>
                            <input class="form-control" type="date" id="from_date">
                        </div>
                        <div class="col-md-3">
                            <label for="to_date">To Date:</label>
                            <input class="form-control" type="date" id="to_date">
                        </div>
                        <div class="col-md-3 align-self-end mt-4">
                            <button id="search" class="btn btn-primary">Search</button>
                            <button id="clear-filters" class="btn btn-secondary">Clear Filters</button>
                        </div>
                    </div>
                    
                    <div class="table-responsive p-0">
                        <table id="voucher-datatable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Account</th>
                                    <th>Voucher Type</th>
                                    <th>Voucher Number</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <!-- Data will be populated by DataTables -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td colspan="3" style="text-align: left;"><b>Total</b></td>
                                    <td id="total-debit" style="text-align: right;"></td>
                                    <td id="total-credit" style="text-align: right;"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="3" style="text-align: left;"><b>Closing Balance</b></td>
                                    <td id="closing-debit" style="text-align: right;"></td>
                                    <td id="closing-credit" style="text-align: right;"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="3" style="text-align: left;"><b>Additional Sum</b></td>
                                    <td id="additional-sum-debit" style="text-align: right;"></td>
                                    <td id="additional-sum-credit" style="text-align: right;"></td>
                                    <td></td>
                                </tr>
                            </tfoot>                            
                        </table>
                    </div>
                </div>
            </div>

            @push('javascript')
                <script>
                    $(document).ready(function() {
                        var openingBalance = 0.00; // Set the initial opening balance value

                        var table = $('#voucher-datatable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('vouchers.get-data') }}",
                                type: 'GET',
                                data: function(d) {
                                    d.ledger_guid = "{{ request()->query('ledger_guid') }}";
                                    d.from_date = $('#from_date').val();
                                    d.to_date = $('#to_date').val();
                                },
                                dataSrc: function(json) {
                                    var openingBalance = 0.00;

                                    if (json.data.length > 0) {
                                        var balance = parseFloat(json.data[0].balance_amount);
                                        var amount = parseFloat(json.data[0].amount);
                                        openingBalance = balance - amount; // Calculate opening balance using the formula
                                    }

                                    // Prepend opening balance row to the data
                                    var openingBalanceRow = {
                                        voucher_date: '', 
                                        credit_ledger: '<b>Opening Balance</b>', 
                                        type: '', 
                                        voucher_number: '', 
                                        debit: openingBalance >= 0 ? openingBalance.toFixed(2) : '0.00', 
                                        credit: openingBalance < 0 ? Math.abs(openingBalance).toFixed(2) : '0.00',
                                        balance_amount: '',
                                    };

                                    if (openingBalance === 0) {
                                        openingBalanceRow.debit = '0.00';
                                        openingBalanceRow.credit = '0.00';
                                    }

                                    json.data.unshift(openingBalanceRow);
                                    return json.data;
                                }
                            },
                            columns: [
                                {data: 'voucher_date', name: 'voucher_date'},
                                {data: 'credit_ledger', name: 'credit_ledger'},
                                {
                                    data: 'type', 
                                    name: 'type',
                                    render: function(data, type, row, meta) {
                                        if (data === 'Bill' || data === 'Rcpt') {
                                            var companyGuid = '{{ $society->guid }}';
                                            var ledgerGuid = row.ledger_guid;
                                            var vchDate = moment(row.voucher_date).format('DD/MM/YYYY');
                                            var vchNumber = row.voucher_number;
                                            var url = 'http://ledger365.in:10000/get_vch_pdf?company_guid=' + companyGuid +
                                                '&ledger_guid=' + ledgerGuid +
                                                '&vch_date=' + vchDate +
                                                '&vch_number=' + vchNumber +
                                                '&vch_type=' + data;

                                            return '<a href="' + url + '" style="color: #337ab7;">' + data + '</a>';
                                        } else {
                                            return data;
                                        }
                                    }
                                },
                                {data: 'voucher_number', name: 'voucher_number'},
                                {data: 'debit', name: 'debit'},
                                {data: 'credit', name: 'credit'},
                                {
                                    data: 'balance_amount',
                                    name: 'balance_amount',
                                    render: function(data, type, row, meta) {
                                        if (isNaN(data) || data === null) {
                                            return "0.00";
                                        }
                                        var balance_amount = parseFloat(data);
                                        if (balance_amount === 0) {
                                            return "0.00";
                                        }
                                        balance_amount = balance_amount.toFixed(2); // Format to 2 decimal places
                                        balance_amount = balance_amount.replace(/\B(?=(\d{3})+(?!\d))/g, ","); // Add commas for thousands
                                        return balance_amount; // Return formatted balance without currency symbol
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
                                'colvis'
                            ],
                            paging: false, // Disable pagination
                            order: [[0, 'asc']],
                            drawCallback: function(settings) {
                                calculateClosingBalance();
                                calculateAdditionalSum();
                            }
                        });

                        $('#search').click(function() {
                            table.draw();
                        });

                        $('#clear-filters').click(function () {
                            $("#from_date").val('').trigger('change');
                            $("#to_date").val('').trigger('change');
                            table.search('').draw();
                        });

                        function calculateClosingBalance() {
                                var totalDebit = 0.00;
                                var totalCredit = 0.00;

                                $('#voucher-datatable tbody tr').each(function() {
                                    var debit = parseFloat($(this).find('td:nth-child(5)').text().replace(/,/g, '')) || 0;
                                    var credit = parseFloat($(this).find('td:nth-child(6)').text().replace(/,/g, '')) || 0;
                                    totalDebit += debit;
                                    totalCredit += credit;
                                });

                                $('#total-debit').text(totalDebit.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                                $('#total-credit').text(totalCredit.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));

                                var totalBalance = totalCredit - totalDebit;

                                // Check if the total balance is positive or negative
                                if (totalBalance >= 0) {
                                    $('#closing-debit').text(totalBalance.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                                    $('#closing-credit').text('0.00');
                                } else {
                                    $('#closing-debit').text('0.00');
                                    $('#closing-credit').text(Math.abs(totalBalance).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                                }
                            }


                        // function calculateAdditionalSum() {
                        //     var additionalSumDebit = 0.00;
                        //     var additionalSumCredit = 0.00;

                        //     $('#voucher-datatable tbody tr').each(function() {
                        //         var debit = parseFloat($(this).find('td:nth-child(5)').text().replace(/,/g, '')) || 0;
                        //         var credit = parseFloat($(this).find('td:nth-child(6)').text().replace(/,/g, '')) || 0;
                        //         additionalSumDebit += debit;
                        //         additionalSumCredit += credit;
                        //     });

                        //     var closingBalance = parseFloat($('#closing-balance').text().replace(/,/g, '')) || 0;
                        //     additionalSumCredit += closingBalance;

                        //     $('#additional-sum-debit').text(additionalSumDebit.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        //     $('#additional-sum-credit').text(additionalSumCredit.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        // }

                        function calculateAdditionalSum() {
                            var additionalSumDebit = 0.00;
                            var additionalSumCredit = 0.00;

                            $('#voucher-datatable tbody tr').each(function() {
                                var debit = parseFloat($(this).find('td:nth-child(5)').text().replace(/,/g, '')) || 0;
                                var credit = parseFloat($(this).find('td:nth-child(6)').text().replace(/,/g, '')) || 0;
                                additionalSumDebit += debit;
                                additionalSumCredit += credit;
                            });

                            var closingDebit = parseFloat($('#closing-debit').text().replace(/,/g, '')) || 0;
                            var closingCredit = parseFloat($('#closing-credit').text().replace(/,/g, '')) || 0;

                            additionalSumDebit += closingDebit;
                            additionalSumCredit += closingCredit;

                            $('#additional-sum-debit').text(additionalSumDebit.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                                $('#additional-sum-credit').text(additionalSumCredit.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                            }

                        // Initial calculation
                        calculateClosingBalance();
                        calculateAdditionalSum();

                        // Handle click event on download-pdf links
                        $(document).on('click', '.download-pdf', function(e) {
                            e.preventDefault(); // Prevent default behavior of anchor tag
                            var voucherId = $(this).data('voucher-id'); // Get voucher id from data attribute
                            var url = "{{ route('voucherEntry.index') }}?voucher_id=" + voucherId; // Construct the URL for PDF view
                            window.location.href = url; // Redirect to the URL for downloading PDF
                        });
                    });
                </script>
            @endpush
        </div>
    </div>
@endsection
