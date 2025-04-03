@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">
                    <i class="fas fa-users me-2"></i>Students - {{ $subject->subject }} / {{ $stage->name }} / {{ $grade->name }}
                </h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('payments.select-subject') }}">Subjects</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('payments.select-stage', $subject) }}">{{ $subject->subject }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('payments.select-grade', [$subject, $stage]) }}">{{ $stage->name }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $grade->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-list me-2"></i>Students List
                <span class="badge bg-light text-dark ms-2">{{ $students->count() }} students</span>
            </h6>
            <div>
                <span class="me-3">Monthly Fee: {{ number_format($price->price, 2) }}</span>
                <a href="#" 
   class="btn btn-light text-primary"
   data-bs-toggle="modal" 
   data-bs-target="#unpaidModal">
    <i class="fas fa-search-dollar me-1"></i> Find Unpaid Students
</a>

<!-- Unpaid Students Modal -->
<div class="modal fade" id="unpaidModal" tabindex="-1" aria-labelledby="unpaidModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="unpaidModalLabel">
                    <i class="fas fa-search-dollar me-2"></i>Find Unpaid Students
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="GET" action="{{ route('payments.unpaid-users', [$subject, $stage, $grade]) }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="month" class="form-label">Month</label>
                        <select class="form-select" id="month" name="month" required>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $i == now()->month ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <input type="number" class="form-control" id="year" name="year" 
                               value="{{ now()->year }}" min="2000" max="{{ now()->year + 1 }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i> Find
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Last Payment</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40 me-3">
                                        <span class="symbol-label bg-light-primary text-primary fs-6 fw-bold">
                                            {{ substr($student->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">{{ $student->name }}</span>
                                        <div class="text-muted small">{{ $student->parent_phone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($student->payments->last())
                                    {{ DateTime::createFromFormat('!m', $student->payments->last()->month)->format('M') }} {{ $student->payments->last()->year }}
                                @else
                                    <span class="text-danger">Never paid</span>
                                @endif
                            </td>
                            <td>
                                @if($student->payments->last())
                                    <span class="badge bg-{{ $student->payments->last()->status ? 'success' : 'warning' }}">
                                        {{ $student->payments->last()->status ? 'Paid' : 'Pending' }}
                                    </span>
                                @else
                                    <span class="badge bg-danger">Unpaid</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('payments.create-payment', [$subject, $stage, $grade, $student]) }}" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-money-bill-wave me-1"></i> Record Payment
                                </a>
                                <a href="{{ route('payments.edit', [$student]) }}" 
                                   class="btn btn-sm btn-secondary">
                                    <i class="fas fa-money-bill-wave me-1"></i> Edit Payment
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection