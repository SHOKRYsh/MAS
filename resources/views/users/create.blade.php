@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">
                    <i class="fas fa-user-plus me-2"></i>Create New Student
                </h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Students</a></li>
                        <li class="breadcrumb-item active">Create</li>
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
            <form action="{{ route('users.store') }}" method="POST" id="studentForm">
                @csrf

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
                                               id="name" name="name" value="{{ old('name') }}" required>
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
                                               id="parent_phone" name="parent_phone" value="{{ old('parent_phone') }}" required>
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
                                               id="year" name="year" value="{{ old('year') ?? date('Y') }}">
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
                                            <option value="{{ $stage->id }}" {{ old('stage_id') == $stage->id ? 'selected' : '' }}>
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
                                        <option value="">Select Grade</option>
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
                                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
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
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Create Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stageSelect = document.getElementById('stage_id');
        const gradeSelect = document.getElementById('grade_id');
        
        // Fetch grades when stage changes
        stageSelect.addEventListener('change', function() {
            const stageId = this.value;
            
            // Clear existing options
            gradeSelect.innerHTML = '<option value="">Select Grade</option>';
            
            if (!stageId) return;
            
            // Show loading state
            gradeSelect.disabled = true;
            const defaultOption = gradeSelect.querySelector('option');
            defaultOption.textContent = 'Loading grades...';
            
            // Fetch grades via AJAX (recommended approach)
            fetch(`/api/stages/${stageId}/grades`)
                .then(response => response.json())
                .then(grades => {
                    gradeSelect.innerHTML = '<option value="">Select Grade</option>';
                    grades.forEach(grade => {
                        const option = document.createElement('option');
                        option.value = grade.id;
                        option.textContent = grade.name;
                        gradeSelect.appendChild(option);
                    });
                    gradeSelect.disabled = false;
                    
                    // Select old value if exists
                    @if(old('grade_id'))
                        gradeSelect.value = "{{ old('grade_id') }}";
                    @endif
                })
                .catch(error => {
                    console.error('Error fetching grades:', error);
                    gradeSelect.innerHTML = '<option value="">Error loading grades</option>';
                    gradeSelect.disabled = false;
                });
        });
        
        // Trigger change event if stage has old value
        @if(old('stage_id'))
            stageSelect.dispatchEvent(new Event('change'));
        @else
            // Initial load if no old value
            stageSelect.dispatchEvent(new Event('change'));
        @endif
        
        // Form validation
        const form = document.getElementById('studentForm');
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
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
</style>
@endsection