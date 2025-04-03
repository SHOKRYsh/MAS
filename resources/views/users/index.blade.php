@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold text-primary">
                    <i class="fas fa-user-graduate me-2"></i>Students Management
                </h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light p-2 rounded">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Students</li>
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

    <!-- Subject Filter Tabs -->
    <ul class="nav nav-tabs mb-4" id="subjectTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="english-tab" data-bs-toggle="tab" data-bs-target="#english" type="button" role="tab">
                <i class="fas fa-book me-1"></i> English
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="technology-tab" data-bs-toggle="tab" data-bs-target="#technology" type="button" role="tab">
                <i class="fas fa-laptop-code me-1"></i> Technology
            </button>
        </li>
    </ul>

    <div class="tab-content" id="subjectTabContent">
        <!-- English Tab -->
        <div class="tab-pane fade show active" id="english" role="tabpanel">
            <div class="row mb-4">
                @foreach($englishStages as $stage)
                <div class="col-md-12 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white py-2">
                            <h5 class="m-0">{{ $stage->name }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($stage->grades as $grade)
                                <div class="col-md-3 mb-3">
                                    <div class="card grade-card shadow-sm h-100" 
                                         data-subject="english"
                                         data-stage="{{ $stage->id }}" 
                                         data-grade="{{ $grade->id }}"
                                         style="cursor: pointer; border-left: 4px solid #4e73df;">
                                        <div class="card-body text-center">
                                            <h6 class="card-title">{{ $grade->name }}</h6>
                                            <span class="badge bg-info">
                                                {{ $grade->english_students_count }} students
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Technology Tab -->
        <div class="tab-pane fade" id="technology" role="tabpanel">
            <div class="row mb-4">
                @foreach($technologyStages as $stage)
                <div class="col-md-12 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white py-2">
                            <h5 class="m-0">{{ $stage->name }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($stage->grades as $grade)
                                <div class="col-md-3 mb-3">
                                    <div class="card grade-card shadow-sm h-100" 
                                         data-subject="technology"
                                         data-stage="{{ $stage->id }}" 
                                         data-grade="{{ $grade->id }}"
                                         style="cursor: pointer; border-left: 4px solid #1cc88a;">
                                        <div class="card-body text-center">
                                            <h6 class="card-title">{{ $grade->name }}</h6>
                                            <span class="badge bg-success">
                                                {{ $grade->technology_students_count }} students
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Students Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
            <div class="d-flex align-items-center position-relative">
                <h6 class="m-0 font-weight-bold me-3">
                    <i class="fas fa-list me-2"></i>Students List
                    <span id="filter-indicator" class="badge bg-light text-dark ms-2 d-none"></span>
                </h6>
                <form id="searchForm" method="GET" action="{{ route('users.index') }}" class="d-flex">
                    <div class="input-group input-group-sm me-2" style="width: 250px;">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" 
                               class="form-control" 
                               name="search" 
                               placeholder="Search by name..." 
                               value="{{ request('search') }}"
                               id="searchInput"
                               autocomplete="off">
                        @if(request('search'))
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                    <span id="searchLoading" class="position-absolute" style="right: 40px; top: 50%; transform: translateY(-50%); display: none;">
                        <div class="spinner-border spinner-border-sm text-light" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </span>
                </form>
            </div>
            <div>
                <button id="clear-filter" class="btn btn-light btn-sm text-primary me-2 d-none">
                    <i class="fas fa-times me-1"></i> Clear Filter
                </button>
                <h6 class="m-0 font-weight-bold">
                    <a href="{{ route('users.create') }}" class="btn btn-light text-primary">
                        <i class="fas fa-plus me-1"></i> Add New Student
                    </a>
                </h6>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="studentsTable">
                    <thead class="bg-light">
                        <tr>
                            <th>Student</th>
                            <th>Contact</th>
                            <th>Academic Info</th>
                            <th>Year</th>
                            <th>Rating</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="student-row" 
                            data-subject="{{ strtolower($user->subjects->subject ?? '') }}"
                            data-stage="{{ $user->stage_id }}" 
                            data-grade="{{ $user->grade_id }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40 symbol-light-primary me-3">
                                        <span class="symbol-label bg-light-primary text-primary fs-6 fw-bold">
                                            {{ substr($user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">{{ $user->name }}</span>
                                        <div class="text-muted small">ID: {{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span><i class="fas fa-phone me-2 text-muted"></i>{{ $user->parent_phone }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-info">{{ $user->stage->name ?? 'N/A' }}</span>
                                    <span class="badge bg-success">{{ $user->grade->name ?? 'N/A' }}</span>
                                    <span class="badge bg-warning text-dark">{{ $user->subjects->subject ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td>{{ $user->year }}</td>
                            <td>
                                @if($user->rating)
                                    @php
                                        $avgRating = $user->rating->rate;
                                        $fullStars = floor($avgRating);
                                        $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                                    @endphp
                                    
                                    <div class="d-flex align-items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $fullStars)
                                                <i class="fas fa-star text-warning me-1"></i>
                                            @elseif($i == $fullStars + 1 && $hasHalfStar)
                                                <i class="fas fa-star-half-alt text-warning me-1"></i>
                                            @else
                                                <i class="far fa-star text-warning me-1"></i>
                                            @endif
                                        @endfor
                                        <small class="text-muted ms-1">({{ number_format($avgRating, 1) }})</small>
                                    </div>
                                @else
                                    <span class="text-muted">Not rated</span>
                                @endif
                            </td>
                                   <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('users.show', $user->id) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="View Details"
                                       data-bs-toggle="tooltip">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}" 
                                       class="btn btn-sm btn-warning"
                                       title="Edit"
                                       data-bs-toggle="tooltip">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger"
                                                title="Delete"
                                                data-bs-toggle="tooltip"
                                                data-student-name="{{ $user->name }}">
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
        </div>
        <div class="card-footer bg-light">
            {{ $users->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }
    
    .grade-card {
        transition: all 0.3s ease;
    }
    
    .grade-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,0.02);
    }
    
    .badge {
        font-size: 0.85em;
        padding: 0.5em 0.75em;
    }
    
    .btn-sm {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .symbol {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }
    
    .symbol-label {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    .student-row.hidden {
        display: none;
    }
    
    .nav-tabs .nav-link {
        color: #6c757d;
        font-weight: 500;
    }
    
    .nav-tabs .nav-link.active {
        color: #4e73df;
        font-weight: 600;
    }
    
    .input-group-sm {
        position: relative;
    }
    
    #searchLoading {
        z-index: 100;
    }
    
    .input-group-sm .btn-outline-secondary {
        border-left: none;
    }
</style>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Auto-search implementation
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        const searchLoading = document.getElementById('searchLoading');
        let searchTimeout = null;

        if (searchInput && searchForm) {
            searchInput.addEventListener('input', function() {
                // Show loading indicator
                if (searchLoading) searchLoading.style.display = 'block';
                
                // Clear previous timeout if it exists
                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }

                // Set a new timeout
                searchTimeout = setTimeout(() => {
                    // Only submit if the input has value or we're clearing a previous search
                    if (this.value.trim() !== '' || this.value === '') {
                        searchForm.submit();
                    }
                }, 800); // 0.8 second delay
            });
        }

        // Clear search when clicking X
        document.querySelector('.btn-outline-secondary')?.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = this.href;
        });

        // Grade card filtering
        const gradeCards = document.querySelectorAll('.grade-card');
        const studentRows = document.querySelectorAll('.student-row');
        const clearFilterBtn = document.getElementById('clear-filter');
        const filterIndicator = document.getElementById('filter-indicator');
        const tabButtons = document.querySelectorAll('#subjectTab button');
        
        // Current filter state
        let currentFilter = {
            subject: null,
            stage: null,
            grade: null
        };
        
        // Delete confirmation with SweetAlert
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const studentName = this.querySelector('button').getAttribute('data-student-name');
                
                Swal.fire({
                    title: 'Are you sure?',
                    html: `You are about to permanently delete <strong>${studentName}</strong>. This action cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
});
        // Apply filter function
        function applyFilter() {
            studentRows.forEach(row => {
                const matchesSubject = !currentFilter.subject || 
                                     row.dataset.subject === currentFilter.subject;
                const matchesStage = !currentFilter.stage || 
                                   row.dataset.stage === currentFilter.stage;
                const matchesGrade = !currentFilter.grade || 
                                   row.dataset.grade === currentFilter.grade;
                
                if (matchesSubject && matchesStage && matchesGrade) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
            
            // Update UI
            if (currentFilter.subject || currentFilter.stage || currentFilter.grade) {
                clearFilterBtn.classList.remove('d-none');
                
                // Get display names for filter indicator
                let subjectName = currentFilter.subject === 'english' ? 'English' : 
                                currentFilter.subject === 'technology' ? 'Technology' : '';
                let stageName = document.querySelector(`.grade-card[data-stage="${currentFilter.stage}"]`)?.closest('.card-header')?.querySelector('h5')?.textContent || '';
                let gradeName = document.querySelector(`.grade-card[data-grade="${currentFilter.grade}"]`)?.querySelector('.card-title')?.textContent || '';
                
                filterIndicator.textContent = `${subjectName} ${stageName} ${gradeName}`.trim();
                filterIndicator.classList.remove('d-none');
            } else {
                clearFilterBtn.classList.add('d-none');
                filterIndicator.classList.add('d-none');
            }
        }
        
        // Grade card click handler
        gradeCards.forEach(card => {
            card.addEventListener('click', function() {
                currentFilter.subject = this.dataset.subject;
                currentFilter.stage = this.dataset.stage;
                currentFilter.grade = this.dataset.grade;
                
                // Highlight active card
                gradeCards.forEach(c => c.classList.remove('bg-light'));
                this.classList.add('bg-light');
                
                applyFilter();
            });
        });
        
        // Clear filter
        clearFilterBtn.addEventListener('click', function() {
            currentFilter = { subject: null, stage: null, grade: null };
            gradeCards.forEach(c => c.classList.remove('bg-light'));
            applyFilter();
        });
        
        // Tab switch handler
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Clear filters when switching tabs
                currentFilter = { subject: null, stage: null, grade: null };
                gradeCards.forEach(c => c.classList.remove('bg-light'));
                applyFilter();
            });
        });
    });
</script>
@endsection
@endsection