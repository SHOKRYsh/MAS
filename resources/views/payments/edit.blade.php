@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">
                    <i class="fas fa-edit me-2"></i>Edit Payment Record
                </h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">Payments</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-money-bill-wave me-2"></i>Payment Details
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('payments.update', $payment->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="student_name" class="form-label">Student Name</label>
                            <input type="text" class="form-control" id="student_name" 
                                   value="{{ $student->name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="subject_name" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject_name" 
                                   value="{{ $payment->subject->subject ?? 'N/A' }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="month" class="form-label">Month</label>
                            <select class="form-select" id="month" name="month" required>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $payment->month == $i ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="year" class="form-label">Year</label>
                            <select class="form-select" id="year" name="year" required>
                                @for($i = now()->year; $i >= 2000; $i--)
                                    <option value="{{ $i }}" {{ $payment->year == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="status" class="form-label">Payment Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="1" {{ $payment->status ? 'selected' : '' }}>Paid</option>
                                <option value="0" {{ !$payment->status ? 'selected' : '' }}>Unpaid</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Hidden fields for required relationships -->
                <input type="hidden" name="user_id" value="{{ $payment->user_id }}">
                <input type="hidden" name="subject_id" value="{{ $payment->subject_id }}">

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .card-header {
        border-bottom: none;
    }
    .form-select, .form-control {
        background-color: #f8f9fa;
    }
</style>
@endsection