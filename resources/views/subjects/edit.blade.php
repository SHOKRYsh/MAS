@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">
                    <i class="fas fa-book me-2"></i>Edit Subject
                </h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Subjects</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-edit me-2"></i>Subject Details
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
                @csrf
                @method('PUT')
        
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-6"> <!-- Adjusted column width for better form sizing -->
                        <div class="mb-4"> <!-- Increased margin-bottom -->
                            <label for="name" class="form-label fw-semibold">Subject Name</label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $subject->name) }}" 
                                   placeholder="Enter subject name"
                                   required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
        
                <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                    <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back to Subjects
                    </a>
                    <div class="btn-group">
                        <a href="{{ route('subject.details', $subject->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-eye me-2"></i> View Details
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i> Update
                        </button>
                    </div>
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
    .form-control, .form-select {
        background-color: #f8f9fa;
    }
    .breadcrumb {
        background-color: transparent;
        padding: 0;
    }
</style>
@endsection