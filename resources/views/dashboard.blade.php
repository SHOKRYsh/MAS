@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <!-- Students Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Students</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStudents }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Projected Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalProjectedRevenue, 2) }} EGP</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ratings Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Ratings Given</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRatings }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unrated Students Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Unrated Students</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $unratedStudents }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Ratings Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Ratings Overview</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="ratingsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rating Distribution -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rating Distribution</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="ratingPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach($ratingDistribution['labels'] as $index => $label)
                        <span class="mr-2">
                            <i class="fas fa-circle" style="color: {{ $ratingDistribution['colors'][$index] }}"></i> {{ $label }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stage Distribution Charts -->
    <div class="row">
        <!-- English Stages Distribution -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">English Students by Stage</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="englishStagesChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach($stageDistribution['english']['labels'] as $index => $label)
                        <span class="mr-2">
                            <i class="fas fa-circle" style="color: {{ $stageDistribution['english']['colors'][$index] }}"></i> {{ $label }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Technology Stages Distribution -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Technology Students by Stage</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="technologyStagesChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach($stageDistribution['technology']['labels'] as $index => $label)
                        <span class="mr-2">
                            <i class="fas fa-circle" style="color: {{ $stageDistribution['technology']['colors'][$index] }}"></i> {{ $label }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Financial Distribution -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Student Distribution & Financial Overview</h6>
                </div>
                <div class="card-body">
                    @foreach($studentDistribution as $subject => $groups)
                    <div class="mb-5 border-bottom pb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="font-weight-bold mb-0">{{ $subject }}</h4>
                            <div>
                                <span class="badge bg-primary mr-2">{{ $groups->sum('student_count') }} students</span>
                                <span class="badge bg-success">${{ number_format($groups->sum('projected_revenue'), 2) }}</span>
                            </div>
                        </div>
                        
                        @foreach($groups->groupBy('stage_name') as $stage => $grades)
                        <div class="mb-4 pl-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="small font-weight-bold mb-0">{{ $stage }}</h5>
                                <span class="badge bg-info">${{ number_format($grades->sum('projected_revenue'), 2) }}</span>
                            </div>
                            <div class="row">
                                @foreach($grades as $grade)
                                <div class="col-md-3 mb-3">
                                    <div class="card border-left-info h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                        {{ $grade->grade_name }}</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        {{ $grade->student_count }} students
                                                    </div>
                                                    <div class="mt-2 text-xs font-weight-bold text-success">
                                                        ${{ number_format($grade->projected_revenue, 2) }}
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Ratings Table -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Ratings</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Subject</th>
                                    <th>Rating</th>
                                    <th>Date</th>
                                    <th>Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentRatings as $rating)
                                <tr>
                                    <td>{{ $rating->user->name }}</td>
                                    <td>{{ $rating->subject->subject }}</td>
                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $rating->rate ? ' text-warning' : ' text-secondary' }}"></i>
                                        @endfor
                                    </td>
                                    <td>{{ $rating->created_at->format('M d, Y') }}</td>
                                    <td>{{ Str::limit($rating->notes, 50) }}</td>
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

@section('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ratings Line Chart
    var ctx = document.getElementById('ratingsChart').getContext('2d');
    var ratingsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($ratingChart['labels']),
            datasets: [{
                label: 'Ratings Given',
                data: @json($ratingChart['data']),
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: 'rgba(78, 115, 223, 1)',
                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointBorderColor: '#fff',
                pointHoverRadius: 5,
                pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointHoverBorderColor: '#fff',
                pointHitRadius: 10,
                pointBorderWidth: 2,
                tension: 0.3
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Rating Distribution Pie Chart
    var ctx2 = document.getElementById('ratingPieChart').getContext('2d');
    var ratingPieChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: @json($ratingDistribution['labels']),
            datasets: [{
                data: @json($ratingDistribution['data']),
                backgroundColor: @json($ratingDistribution['colors']),
                hoverBorderColor: 'rgba(234, 236, 244, 1)',
            }]
        },
        options: {
            maintainAspectRatio: false,
            cutout: '70%',
        }
    });

    // English Stages Distribution Chart
    var englishStagesCtx = document.getElementById('englishStagesChart').getContext('2d');
    var englishStagesChart = new Chart(englishStagesCtx, {
        type: 'pie',
        data: {
            labels: @json($stageDistribution['english']['labels']),
            datasets: [{
                data: @json($stageDistribution['english']['data']),
                backgroundColor: @json($stageDistribution['english']['colors']),
                hoverBorderColor: 'rgba(234, 236, 244, 1)',
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.raw || 0;
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} students (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Technology Stages Distribution Chart
    var technologyStagesCtx = document.getElementById('technologyStagesChart').getContext('2d');
    var technologyStagesChart = new Chart(technologyStagesCtx, {
        type: 'pie',
        data: {
            labels: @json($stageDistribution['technology']['labels']),
            datasets: [{
                data: @json($stageDistribution['technology']['data']),
                backgroundColor: @json($stageDistribution['technology']['colors']),
                hoverBorderColor: 'rgba(234, 236, 244, 1)',
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.raw || 0;
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} students (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection

<style>
    .chart-area, .chart-pie {
        position: relative;
        height: 250px;
    }
    .card {
        border-radius: 0.35rem;
    }
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    .badge {
        font-size: 0.85em;
        padding: 0.5em 0.75em;
    }
</style>
@endsection