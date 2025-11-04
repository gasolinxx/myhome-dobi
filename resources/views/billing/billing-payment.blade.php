@extends('layouts.base')
@section('content')

<div class="container-fluid mt-5">
    {{-- Sales Summary --}}
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h6>This Month</h6>
                    <h3>RM {{ isset($salesSummary['thisMonth']) ? number_format($salesSummary['thisMonth'], 2) : '0.00' }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h6>This Year</h6>
                    <h3>RM {{ isset($salesSummary['thisYear']) ? number_format($salesSummary['thisYear'], 2) : '0.00' }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h6>Total</h6>
                    <h3>RM {{ isset($salesSummary['total']) ? number_format($salesSummary['total'], 2) : '0.00' }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>


    {{-- Sales Chart --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Total Sales</h4>
                <div style="height: 300px; overflow: hidden;">
                    <canvas id="sales-chart-canvas" style="height: 100%; width: 100%;"></canvas>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    var ctx = document.getElementById('sales-chart-canvas').getContext('2d');
                    var salesChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            datasets: [{
                                label: 'Sales',
                                data: @json(array_values($salesData)), // Pass PHP array as JSON
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>


    {{-- Sales List --}}
    <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Sales List</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Sales Month</th>
                                <th>Year</th>
                                <th>Total Sales</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $key => $sale)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $sale->month ? DateTime::createFromFormat('!m', $sale->month)->format('F') : 'Invalid Month' }}</td>
                                    <td>{{ $sale->year }}</td>
                                    <td>RM {{ number_format($sale->total_sales, 2) }}</td>
                                    <td>
                                        <a href="{{ route('sales.details', ['month' => $sale->month, 'year' => $sale->year]) }}" class="btn btn-info btn-sm">View</a>
                                    </td>
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
