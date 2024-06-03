@extends('layouts.app')
@section('title', __('Voucher Entry Management'))
@section('content')
    @include('layouts.partials.topnav', ['title' => 'Voucher Entry Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="alert alert-light" role="alert">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="text-center text-black">
                                    @if($vouchers->isNotEmpty())
                                        @foreach ($vouchers as $voucher)
                                            <p>{{ $voucher->type }}<p>
                                        @endforeach
                                    @else
                                        <h2>No Vouchers Found</h2>
                                    @endif

                                    @if($society)
                                        <h3><b>{{ $society->name }}</b></h3>
                                        <h6>{{ $society->address1 }}</h6>
                                    @else
                                        <h6>No Society Information Found</h6>
                                    @endif

                                    @if($members)
                                            <div>
                                                <h6>{{ $members->name }}</h6>
                                                <h6>{{ $members->alias1 }}</h6>
                                            </div>
                                    @else
                                        <h6>No Member Information Found</h6>
                                    @endif

                                    @if($vouchers->isNotEmpty())
                                        @foreach ($vouchers as $voucher)
                                            <p>{{ $voucher->credit_ledger }}</p>
                                        @endforeach
                                    @endif
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pt-6">
                    <div class="table-responsive p-0">
                        <table id="voucherEntry-datatable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SR. NO.</th>
                                    <th>Particular</th>
                                    <th>Amount</th>
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
                        var table = $('#voucherEntry-datatable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('voucherEntry.get-data') }}",
                                type: 'GET',
                                data: function(d) {
                                    d.voucher_id = "{{ request()->query('voucher_id') }}";
                                }
                            },
                            columns: [
                                {data: 'id', name: 'id'},
                                {data: 'ledger', name: 'ledger'},
                                {data: 'amount', name: 'amount'},
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
