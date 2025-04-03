@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header bg-{{ $subject->subject == 'English' ? 'primary' : 'success' }} text-white">
        <h5>
            <i class="fas fa-{{ $subject->subject == 'English' ? 'book-open' : 'laptop-code' }} me-2"></i>
            {{ $subject->subject }} - {{ $stage->name }} - {{ $grade->name }}
        </h5>
    </div>
    <div class="card-body">
        @if ($students->isEmpty())
        <div class="alert alert-info">No students found in this grade.</div>
        @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Current Rating</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                    @php
                        // Get the student's rating for this subject
                        $studentRating = $student->rating()
                            ->where('subject_id', $subject->id)
                            ->first();
                    @endphp
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
                            @if ($studentRating)
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $studentRating->rate ? ' text-warning' : ' text-secondary' }}"></i>
                                @endfor
                                <small class="text-muted">({{ $studentRating->rate }}/5)</small>
                            @else
                                <span class="text-muted">Not rated yet</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('rates.create', [$subject, $stage, $grade, $student]) }}"
                                    class="btn btn-sm btn-{{ $subject->subject == 'English' ? 'primary' : 'success' }}">
                                    <i class="fas fa-star me-1"></i>
                                    {{ $studentRating ? 'Update' : 'Add' }}
                                </a>
                                
                                @if($studentRating)
                                <form action="{{ route('rates.destroy', $studentRating->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger"
                                            title="Delete rating for {{ $student->name }}"
                                            data-bs-toggle="tooltip">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </form>
                                @endif
                                
                                <a href="{{ route('users.show', $student->id) }}"
                                    class="btn btn-sm btn-outline-{{ $subject->subject == 'English' ? 'primary' : 'success' }}">
                                    <i class="fas fa-eye me-1"></i>
                                    Profile
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@push('scripts')
<script>
    document.querySelectorAll('.delete-form button[type="submit"]').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('form');
        const studentName = this.getAttribute('data-student-name');

        Swal.fire({
            title: 'Delete Rating?',
            text: `You are about to delete the rating for ${studentName}`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

</script>
@endpush
@endsection