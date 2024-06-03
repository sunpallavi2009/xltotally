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
                            <input class="form-control" type="date" value="YYYY-MM-DD" id="from_date" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>
                        <div class="col-md-3">
                            <label for="to_date">To Date:</label>
                            <input class="form-control" type="date" value="YYYY-MM-DD" id="to_date" onfocus="focused(this)" onfocusout="defocused(this)">
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
                                    <th>SR. NO.</th>
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
                        </table>
                    </div>
                </div>
            </div>

            @push('javascript')
                <script>
                    $(document).ready(function() {
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
                                }
                            },
                            columns: [
                                {data: 'id', name: 'id'},
                                {data: 'voucher_date', name: 'voucher_date'},
                                {data: 'credit_ledger', name: 'credit_ledger'},
                                {
                                    data: 'type', 
                                    name: 'type',
                                    render: function(data, type, row, meta) {
                                        var url = "{{ route('voucherEntry.index') }}?voucher_id=" + row.id;
                                        return '<a href="' + url + '" style="color: #337ab7;">' + data + '</a>';
                                    }
                                },
                                {data: 'voucher_number', name: 'voucher_number'},
                                {data: 'debit', name: 'debit'},
                                {data: 'credit', name: 'credit'},
                                {data: 'balance_amount', name: 'balance_amount'},
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
                            order: [[0, 'asc']],
                        });

                        $('#search').click(function() {
                            table.draw();
                        });

                        $('#clear-filters').click(function () {
                            $("#from_date").val('').trigger('change');
                            $("#to_date").val('').trigger('change');
                            table.search('').draw();
                        });
                    });
                </script>
            @endpush
        </div>
    </div>
@endsection
