@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header bg-{{ $subject->subject == 'English' ? 'primary' : 'success' }} text-white">
        <h5>
            <i class="fas fa-{{ $subject->subject == 'English' ? 'book-open' : 'laptop-code' }} me-2"></i>
            {{ $subject->subject }} - {{ $stage->name }} - Select Grade
        </h5>
    </div>
    <div class="card-body">
        @if($stage->grades->isEmpty())
            <div class="alert alert-info">No grades available in this stage.</div>
        @else
            <div class="row">
                @foreach($stage->grades as $grade)
                <div class="col-md-4 mb-3">
                    <a href="{{ route('rates.show-students', [$subject, $stage, $grade]) }}" 
                       class="card grade-card h-100 text-decoration-none">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $grade->name }}</h5>
                            <p class="text-muted mb-1">
                                {{ $grade->students()->where('subject_id', $subject->id)->count() }} students
                            </p>
                            <small class="text-primary">Click to view students</small>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection