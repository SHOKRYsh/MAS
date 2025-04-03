@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">
                    <i class="fas fa-user-edit me-2"></i>Edit Student
                </h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Students</a></li>
                        <li class="breadcrumb-item active">Edit {{ $user->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="m-0 font-weight-bold">
                <i class="fas fa-user-graduate me-2"></i>Student Information
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST" id="editStudentForm">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Personal Information -->
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="m-0 font-weight-bold">
                                    <i class="fas fa-id-card me-2"></i>Personal Details
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="parent_phone" class="form-label">Parent's Phone</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="text" class="form-control @error('parent_phone') is-invalid @enderror" 
                                               id="parent_phone" name="parent_phone" value="{{ old('parent_phone', $user->parent_phone) }}" required>
                                    </div>
                                    @error('parent_phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="year" class="form-label">Academic Year</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="text" class="form-control @error('year') is-invalid @enderror" 
                                               id="year" name="year" value="{{ old('year', $user->year) }}" required>
                                    </div>
                                    @error('year')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Information -->
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="m-0 font-weight-bold">
                                    <i class="fas fa-graduation-cap me-2"></i>Academic Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="stage_id" class="form-label">Stage</label>
                                    <select class="form-select @error('stage_id') is-invalid @enderror" 
                                            id="stage_id" name="stage_id" required>
                                        @foreach($stages as $stage)
                                            <option value="{{ $stage->id }}" {{ old('stage_id', $user->stage_id) == $stage->id ? 'selected' : '' }}>
                                                {{ $stage->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('stage_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="grade_id" class="form-label">Grade</label>
                                    <select class="form-select @error('grade_id') is-invalid @enderror" 
                                            id="grade_id" name="grade_id" required>
                                        @foreach($grades as $grade)
                                            <option value="{{ $grade->id }}" {{ old('grade_id', $user->grade_id) == $grade->id ? 'selected' : '' }}>
                                                {{ $grade->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('grade_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="subject_id" class="form-label">Subject</label>
                                    <select class="form-select @error('subject_id') is-invalid @enderror" 
                                            id="subject_id" name="subject_id" required>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ old('subject_id', $user->subject_id) == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->subject }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subject_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Students
                    </a>
                    <div>
                        <button type="reset" class="btn btn-outline-danger me-2">
                            <i class="fas fa-undo me-1"></i> Reset Changes
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Student
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Form validation
        const form = document.getElementById('editStudentForm');
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);

        // Phone number formatting
        const phoneInput = document.getElementById('parent_phone');
        phoneInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>
@endsection

<style>
    .card {
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 15px;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
    }
    
    .invalid-feedback {
        font-size: 0.85em;
    }
    
    .was-validated .form-control:invalid, 
    .was-validated .form-select:invalid {
        border-color: #dc3545;
    }
    
    .btn-outline-danger:hover {
        color: #fff;
    }
</style>
@endsection