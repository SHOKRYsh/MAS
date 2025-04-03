@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">
                    <i class="fas fa-archive me-2"></i>Archived Students
                </h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Students</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Archived</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-danger text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-trash-restore me-2"></i>Deleted Students ({{ $metadata['total number'] ?? 0 }})
            </h6>
        </div>
        <div class="card-body">
            @if($archivedUsers->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No archived students found.
                </div>
            @else
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <button id="restoreSelected" class="btn btn-success btn-sm" disabled>
                            <i class="fas fa-trash-restore me-1"></i> Restore Selected
                        </button>
                    </div>
                    <div class="d-flex align-items-center">
                        <form method="GET" action="{{ route('users.archive') }}" class="me-3">
                            <div class="input-group input-group-sm">
                                <select name="field" class="form-select form-select-sm">
                                    <option value="">Filter by...</option>
                                    <option value="year" {{ request('field') == 'year' ? 'selected' : '' }}>Year</option>
                                    <option value="parent_phone" {{ request('field') == 'parent_phone' ? 'selected' : '' }}>Parent Phone</option>
                                </select>
                                <input type="text" name="data" class="form-control form-control-sm" 
                                       placeholder="Value..." value="{{ request('data') }}">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-filter"></i>
                                </button>
                                @if(request('field') || request('data'))
                                    <a href="{{ route('users.archive') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                        {{ $archivedUsers->links() }}
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="50px">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>Name</th>
                                <th>Parent Phone</th>
                                <th>Year</th>
                                <th>Stage</th>
                                <th>Grade</th>
                                <th>Subject</th>
                                <th>Deleted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($archivedUsers as $user)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="user-checkbox" value="{{ $user->id }}">
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->parent_phone }}</td>
                                    <td>{{ $user->year }}</td>
                                    <td>{{ $user->stage->name ?? 'N/A' }}</td>
                                    <td>{{ $user->grade->name ?? 'N/A' }}</td>
                                    <td>{{ $user->subjects->subject ?? 'N/A' }}</td>
                                    <td>{{ $user->deleted_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-success restore-btn" data-id="{{ $user->id }}">
                                            <i class="fas fa-trash-restore"></i> Restore
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    // Check if jQuery is loaded
    if (typeof jQuery == 'undefined') {
        console.error('jQuery is not loaded!');
        return;
    }

    // Enable/disable bulk restore button based on selection
    function toggleRestoreButton() {
        $('#restoreSelected').prop('disabled', $('.user-checkbox:checked').length === 0);
    }

    // Select all checkbox
    $('#selectAll').change(function() {
        $('.user-checkbox').prop('checked', this.checked);
        toggleRestoreButton();
    });

    // Individual checkbox change
    $(document).on('change', '.user-checkbox', function() {
        if ($('.user-checkbox:checked').length !== $('.user-checkbox').length) {
            $('#selectAll').prop('checked', false);
        }
        toggleRestoreButton();
    });

    // Restore action function
    function restoreUsers(ids) {
        console.log('Attempting to restore IDs:', ids); // Debug log
        
        $.ajax({
            url: '{{ route("users.restore") }}',
            type: 'POST',
            data: {
                ids: ids,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(response) {
                console.log('Restore success:', response); // Debug log
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });
            },
            error: function(xhr) {
                console.error('Restore error:', xhr); // Debug log
                let errorMsg = xhr.responseJSON?.message || 'Something went wrong';
                if (xhr.status === 422) {
                    errorMsg = 'Validation error: ' + Object.values(xhr.responseJSON.errors).join(' ');
                }
                Swal.fire({
                    title: 'Error!',
                    text: errorMsg,
                    icon: 'error'
                });
            }
        });
    }

    // Single restore button
    $(document).on('click', '.restore-btn', function(e) {
        e.preventDefault();
        const userId = $(this).data('id');
        console.log('Restore button clicked for ID:', userId); // Debug log
        
        Swal.fire({
            title: 'Restore this student?',
            text: "The student will be restored to active status",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, restore!'
        }).then((result) => {
            if (result.isConfirmed) {
                restoreUsers([userId]);
            }
        });
    });

    // Bulk restore button
    $('#restoreSelected').click(function(e) {
        e.preventDefault();
        const selectedIds = $('.user-checkbox:checked').map(function() {
            return $(this).val();
        }).get();
        
        console.log('Bulk restore for IDs:', selectedIds); // Debug log

        if (selectedIds.length === 0) {
            Swal.fire({
                title: 'No selection',
                text: 'Please select at least one student to restore',
                icon: 'warning'
            });
            return;
        }

        Swal.fire({
            title: 'Restore ' + selectedIds.length + ' student(s)?',
            text: "The selected students will be restored to active status",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, restore all!'
        }).then((result) => {
            if (result.isConfirmed) {
                restoreUsers(selectedIds);
            }
        });
    });
});
</script>
@endsection
<style>
    .table-hover tbody tr:hover {
        background-color: rgba(220, 53, 69, 0.1);
    }
    .restore-btn:hover {
        background-color: #28a745;
        color: white !important;
    }
    .card-header {
        border-bottom: none;
    }
    .form-select, .form-control {
        max-width: 150px;
    }
</style>