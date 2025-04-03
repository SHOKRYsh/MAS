@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="fw-bold">
                        <i class="fas fa-user-graduate me-2"></i>Student Details
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Students</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
                        <h4 class="m-0 font-weight-bold">
                            <i class="fas fa-id-card me-2"></i>{{ $user->name }}'s Information
                        </h4>
                        <div class="dropdown no-arrow">
                            <a class="text-white dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="{{ route('users.edit', $user->id) }}"><i class="fas fa-edit me-1"></i> Edit</a></li>
                                <li>
                                    <form id="deleteForm" action="{{ route('users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="dropdown-item text-danger" onclick="confirmDelete()">
                                            <i class="fas fa-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h5 class="text-primary"><i class="fas fa-user me-2"></i>Basic Information</h5>
                                    <hr class="mt-1 mb-3">
                                    <p><strong>Name:</strong> {{ $user->name }}</p>
                                    <p><strong>Parent Phone:</strong>
                                        <a href="tel:{{ $user->parent_phone }}" class="text-decoration-none">
                                            <i class="fas fa-phone me-1"></i>{{ $user->parent_phone }}
                                        </a>
                                    </p>
                                    <p><strong>Year:</strong> {{ $user->year }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h5 class="text-primary"><i class="fas fa-graduation-cap me-2"></i>Academic Information</h5>
                                    <hr class="mt-1 mb-3">
                                    <p><strong>Stage:</strong>
                                        <span class="badge bg-info text-dark">{{ $user->stage->name ?? 'N/A' }}</span>
                                    </p>
                                    <p><strong>Grade:</strong>
                                        <span class="badge bg-success">{{ $user->grade->name ?? 'N/A' }}</span>
                                    </p>
                                    <p><strong>Subject:</strong>
                                        <span class="badge bg-warning text-dark">{{ $user->subjects->subject ?? 'N/A' }}</span>
                                    </p>
                                    <!-- Rate Information -->
                                    @if($user->rating)
                                        <p><strong>Rating:</strong>
                                            <span class="badge bg-primary">
                                                {{ $user->rating->rate }} / 5
                                                <i class="fas fa-star ms-1"></i>
                                            </span>
                                        </p>
                                        @if($user->rating->notes)
                                            <p><strong>Teacher Notes:</strong>
                                                <span class="text-muted">"{{ $user->rating->notes }}"</span>
                                            </p>
                                        @endif
                                    @else
                                        <p><strong>Rating:</strong>
                                            <span class="badge bg-secondary">Not ratingd yet</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Students
                        </a>
                        <div>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i> Edit Student
                            </a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                                <i class="fas fa-trash me-1"></i> Delete Student
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information Column -->
            <div class="col-lg-4">
                <!-- Student Photo Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-secondary text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-camera me-2"></i>Student Photo
                        </h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="student-photo-placeholder rounded-circle bg-light d-flex align-items-center justify-content-center"
                             style="width: 150px; height: 150px; margin: 0 auto; border: 3px solid #eee;">
                            <i class="fas fa-user fa-4x text-muted"></i>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-upload me-1"></i> Upload Photo
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Rating Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-success text-white d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-star me-2"></i>Student Rating
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($user->rating)
                            <div class="text-center mb-4">
                                <div class="display-2 text-warning fw-bold mb-2">
                                    {{ $user->rating->rate }}
                                    <small class="text-muted fs-4">/ 5</small>
                                </div>
                                <div class="star-rating mb-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star fa-xl {{ $i <= $user->rating->rate ? 'text-warning' : 'text-light' }}"></i>
                                    @endfor
                                </div>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    Rated on {{ $user->rating->created_at->format('M d, Y') }}
                                </p>
                            </div>
                            
                            @if($user->rating->notes)
                                <div class="alert alert-light border">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-comment-alt text-primary me-2"></i>
                                        <h6 class="alert-heading mb-0">Teacher's Notes</h6>
                                    </div>
                                    <hr class="mt-1 mb-2">
                                    <p class="mb-0">{{ $user->rating->notes }}</p>
                                </div>
                            @endif
                            
                            <div class="d-grid gap-2 mt-4">
                                <a href="{{ route('rates.create', [$user->subjects, $user->stage, $user->grade, $user]) }}" 
                                class="btn btn-primary">
                                    <i class="fas fa-edit me-1"></i> Update Rating
                                </a>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="empty-state-icon mb-3">
                                    <i class="fas fa-star fa-4x text-light"></i>
                                </div>
                                <h5 class="text-muted mb-3">No Rating Yet</h5>
                                <p class="text-muted mb-4">This student hasn't been rated yet</p>
                                <a href="{{ route('rates.create', [$user->subjects, $user->stage, $user->grade, $user]) }}" 
                                class="btn btn-success">
                                    <i class="fas fa-plus me-1"></i> Create First Rating
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Quick Actions Card -->
                <div class="card shadow">
                    <div class="card-header py-3 bg-info text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-bolt me-2"></i>Quick Actions
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-outline-primary text-start">
                                <i class="fas fa-envelope me-2"></i> Send Message
                            </a>
                            <a href="#" class="btn btn-outline-warning text-start">
                                <i class="fas fa-file-alt me-2"></i> Generate Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong>{{ $user->name }}</strong>? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteForm').submit()">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border: none;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }

        .badge {
            font-size: 0.9em;
            padding: 0.35em 0.65em;
            font-weight: 500;
        }

        .student-photo-placeholder {
            transition: all 0.3s ease;
        }

        .student-photo-placeholder:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .star-rating {
            font-size: 1.5rem;
            letter-spacing: 0.25rem;
        }
    </style>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm').submit();
            }
        });
    }
</script>
@endsection
@endsection