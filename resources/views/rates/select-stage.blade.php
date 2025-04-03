@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header bg-{{ $subject->subject == 'English' ? 'primary' : 'success' }} text-white">
        <h5>
            <i class="fas fa-{{ $subject->subject == 'English' ? 'book-open' : 'laptop-code' }} me-2"></i>
            {{ $subject->subject }} - Select Stage
        </h5>
    </div>
    <div class="card-body">
        @if($stages->isEmpty())
            <div class="alert alert-info">No stages available for rating.</div>
        @else
            <div class="list-group">
                @foreach($stages as $stage)
                <a href="{{ route('rates.select-grade', [$subject, $stage]) }}" 
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    {{ $stage->name }}
                    <span class="badge bg-primary rounded-pill">
                        {{ $stage->grades->count() }} grades
                    </span>
                </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection