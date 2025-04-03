@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">
                    <i class="fas fa-search-dollar me-2"></i>Unpaid Students
                </h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('payments.select-subject') }}">Subjects</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('payments.select-stage', $subject) }}">{{ $subject->subject }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('payments.select-grade', [$subject, $stage]) }}">{{ $stage->name }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Unpaid - {{ $grade->name }}</li>
                    </ol>
                </nav>
            </div>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Showing unpaid students for {{ DateTime::createFromFormat('!m', $request->month)->format('F') }} {{ $request->year }}
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-users me-2"></i>Unpaid Students List
            </h6>
            <div>
                <span class="me-3">Monthly Fee: ${{ number_format($price->price, 2) }}</span>
                <a href="{{ route('payments.show-students', [$subject, $stage, $grade]) }}" 
                   class="btn btn-light text-primary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Students
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Contact</th>
                            <th>Stage</th>
                            <th>Grade</th>
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
                                        <div class="text-muted small">ID: {{ $student->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $student->parent_phone }}</td>
                            <td>{{ $student->stage->name }}</td>
                            <td>{{ $student->grade['name'] }}</td>
                            <td>
                                <a href="{{ route('payments.create-payment', [$subject, $stage, $grade, $student]) }}?month={{ $request->month }}&year={{ $request->year }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-money-bill-wave me-1"></i> Record Payment
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