@extends('layouts.base')

@section('content')
<div class="container-fluid mt-5">
    <h4 class="header-title">Sales Details for {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</h4>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Customer Name</th>
                                    <th>Laundry Type</th>
                                    <th>Service Type</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($salesDetails as $key => $detail)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $detail->customer_name ?? 'No Name' }}</td>
                                    <td>{{ $detail->laundry_type ?? 'N/A' }}</td>
                                    <td>{{ $detail->service_name ?? 'N/A' }}</td>
                                    <td>RM {{ number_format($detail->total_amount, 2) }}</td>
                                    <td>{{ $detail->status }}</td>
                                    <td>{{ $detail->created_at }}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
