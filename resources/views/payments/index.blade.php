@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">
                    <i class="fas fa-money-bill-wave me-2"></i>Payments Management
                </h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Payments</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-list me-2"></i>Payments List
            </h6>
            <div>
                <a href="{{ route('payments.select-subject') }}" class="btn btn-light text-primary">
                    <i class="fas fa-plus me-1"></i> Add New Payment
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="paymentsTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Student</th>
                            <th>Subject</th>
                            <th>Amount</th>
                            <th>Period</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40 me-3">
                                        <span class="symbol-label bg-light-primary text-primary fs-6 fw-bold">
                                            {{ substr($payment->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">{{ $payment->user->name }}</span>
                                        <div class="text-muted small">ID: {{ $payment->user->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $payment->subject->subject }}</td>
                            <td>${{ number_format($payment->amount, 2) }}</td>
                            <td>
                                {{ DateTime::createFromFormat('!m', $payment->month)->format('F') }} {{ $payment->year }}
                            </td>
                            <td>
                                <span class="badge bg-{{ $payment->status ? 'success' : 'warning' }}">
                                    {{ $payment->status ? 'Paid' : 'Pending' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('payments.edit', $payment->id) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('payments.destroy', $payment->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection