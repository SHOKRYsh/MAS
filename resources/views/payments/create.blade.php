@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="fw-bold">
                        <i class="fas fa-money-bill-wave me-2"></i>Record Payment
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('payments.show-students', [$subject, $stage, $grade]) }}">Students</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $student->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-user-graduate me-2"></i>Student: {{ $student->name }}
                </h6>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <h6>Subject: <span class="fw-bold">{{ $subject->subject }}</span></h6>
                    </div>
                    <div class="col-md-4">
                        <h6>Stage: <span class="fw-bold">{{ $stage->name }}</span></h6>
                    </div>
                    <div class="col-md-4">
                        <h6>Grade: <span class="fw-bold">{{ $grade->name }}</span></h6>
                    </div>
                </div>

                <form method="POST" action="{{ route('payments.store-payment', [$subject, $stage, $grade, $student]) }}">
                    @csrf

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="month" class="form-label">Month</label>
                            <select class="form-select" id="month" name="month" required>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i == $suggestedMonth ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="year" class="form-label">Year</label>
                            <input type="number" class="form-control" id="year" name="year"
                                value="{{ $suggestedYear }}" min="2000" max="{{ date('Y') + 1 }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Payment Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">LE</span>
                            <input type="text" class="form-control" value="{{ number_format($price->price, 2) }}"
                                readonly>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Payment Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="paid" value="1"
                                checked>
                            <label class="form-check-label" for="paid">
                                <i class="fas fa-check-circle text-success me-1"></i> Paid
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="pending" value="0">
                            <label class="form-check-label" for="pending">
                                <i class="fas fa-clock text-warning me-1"></i> Pending
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('payments.show-students', [$subject, $stage, $grade]) }}"
                            class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Students
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save Payment
                        </button>
                    </div>
                </form>

                <!-- Old Payments Section -->
                <div class="mt-5">
                    <h5 class="fw-bold mb-4 border-bottom pb-2">
                        <i class="fas fa-history me-2"></i>Payment History
                    </h5>
                    
                    @if($oldPayments->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> No previous payments found
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Month/Year</th>
                                        <th>Payment Date</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($oldPayments as $payment)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ DateTime::createFromFormat('!m', $payment->month)->format('F') }} {{ $payment->year }}</span>
                                        </td>
                                        <td>
                                            {{ $payment->updated_at->format('M d, Y h:i A') }}
                                        </td>
                                        <td>
                                            @if($payment->status == 1)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i> Paid
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-clock me-1"></i> Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-bold">LE {{ number_format($price->price, 2) }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .payment-history-card {
            border-left: 4px solid #4e73df;
            transition: all 0.3s ease;
        }
        .payment-history-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .payment-status-badge {
            padding: 0.35em 0.65em;
            font-size: 0.85em;
        }
        .payment-amount {
            font-size: 1.1em;
            font-weight: 600;
        }
    </style>
@endsection