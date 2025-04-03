@extends('layouts.app')

@section('content')
<div class="container-fluid">    
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold text-primary">
                    <i class="fas fa-book me-2"></i>{{ $subject->subject }} Details
                </h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Subjects</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        @foreach ($stages as $stageName => $stageUsers)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-3 border-start-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase small">{{ $stageName }} Students</h6>
                            <h3 class="mb-0 fw-bold">{{ $stageUsers->count() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-user-graduate fa-lg text-primary"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="#" class="small text-primary text-decoration-none">
                            View students <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
        <!-- Additional Stats Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-3 border-start-info shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase small">Total Students</h6>
                            <h3 class="mb-0 fw-bold">{{ $users->total() }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-users fa-lg text-info"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="small text-muted">All stages combined</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h6 class="m-0 fw-bold text-primary">
                        <i class="fas fa-users me-2"></i> Students in this Subject
                    </h6>
                    <form method="GET" action="{{ route('subject.details', $subject->id) }}" class="d-flex">
                        <div class="input-group input-group-sm me-2" style="width: 250px;">
                            <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                            <input type="text" 
                                   class="form-control" 
                                   name="search" 
                                   placeholder="Search students..." 
                                   value="{{ request('search') }}"
                                   id="searchInput">
                            @if(request('search'))
                            <a href="{{ route('subject.details', $subject->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="30%">Student</th>
                                    <th width="20%">Stage</th>
                                    <th width="20%">Grade</th>
                                    <th width="10%" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-40 symbol-light-primary me-3">
                                                <span class="symbol-label bg-light-primary text-primary fw-bold">
                                                    {{ substr($user->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <span class="fw-bold">{{ $user->name }}</span>
                                                <div class="text-muted small">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary py-2 px-3">
                                            <i class="fas fa-layer-group me-1"></i> {{ $user->stage->name ?? 'Unknown' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success bg-opacity-10 text-success py-2 px-3">
                                            <i class="fas fa-graduation-cap me-1"></i> {{ $user->grade->name ?? 'Unknown' }}
                                        </span>
                                    </td>
                                  
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="{{ route('users.show', $user->id) }}" 
                                               class="btn btn-sm btn-icon btn-info" 
                                               title="View"
                                               data-bs-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('users.edit', $user->id) }}" 
                                               class="btn btn-sm btn-icon btn-warning" 
                                               title="Edit"
                                               data-bs-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing <span class="fw-bold">{{ $users->firstItem() }}</span> to 
                            <span class="fw-bold">{{ $users->lastItem() }}</span> of 
                            <span class="fw-bold">{{ $users->total() }}</span> students
                        </div>
                        {{ $users->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1.5rem 0 rgba(33, 40, 50, 0.2);
    }
    
    .border-start-3 {
        border-left: 3px solid !important;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
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
    
    .badge {
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    
    .btn-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }
    
    .breadcrumb {
        padding: 0.5rem 1rem;
    }
    
    .main-content {
        margin-left: 250px;
        padding: 20px;
        transition: margin-left 0.3s;
    }
    
    @media (max-width: 768px) {
        .main-content {
            margin-left: 0;
        }
    }
</style>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Auto-submit form when typing stops (1 second delay)
        const searchInput = document.getElementById('searchInput');
        const form = searchInput?.closest('form');
        let searchTimeout = null;

        if (searchInput && form) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    form.submit();
                }, 1000);
            });
        }

        // Clear search when clicking X
        document.querySelector('.btn-outline-secondary')?.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = this.href;
        });
    });
</script>
@endsection
@endsection