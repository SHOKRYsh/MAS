@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5><i class="fas fa-book me-2"></i>Select Subject for Payment</h5>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($subjects as $subject)
            <div class="col-md-6 mb-4">
                <a href="{{ route('payments.select-stage', $subject) }}" class="card subject-card h-100 text-decoration-none">
                    <div class="card-body text-center">
                        <i class="fas fa-{{ $subject->subject == 'English' ? 'book-open' : 'laptop-code' }} fa-3x mb-3 text-{{ $subject->subject == 'English' ? 'primary' : 'success' }}"></i>
                        <h4 class="card-title">{{ $subject->subject }}</h4>
                        <p class="text-muted">{{ $subject->students()->count() }} students</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .subject-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
    }
    .subject-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
</style>
@endsection