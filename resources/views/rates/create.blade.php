@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header bg-{{ $subject->subject == 'English' ? 'primary' : 'success' }} text-white">
        <h5>
            <i class="fas fa-star me-2"></i>
            Rate Student: {{ $student->name }}
        </h5>
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    <div class="card-body">
        <div class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <h6>Subject: <span class="fw-bold">{{ $subject->subject }}</span></h6>
                </div>
                <div class="col-md-4">
                    <h6>Stage: <span class="fw-bold">{{ $stage->name }}</span></h6>
                </div>
                <div class="col-md-4">
                    <h6>Grade: <span class="fw-bold">{{ $grade->name }}</span></h6>
                </div>
            </div>
        </div>

        <form action="{{ route('rates.store', [$subject, $stage, $grade, $student]) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="form-label">Rating</label>
                <div class="rating">
                    @for($i = 5; $i >= 1; $i--)
                        <input type="radio" id="star{{ $i }}" name="rate" value="{{ $i }}" 
                               {{ old('rate', $existingRating->rate ?? '') == $i ? 'checked' : '' }} required/>
                        <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                    @endfor
                </div>
                @error('rate')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Feedback/Comments</label>
                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $existingRating->notes ?? '') }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('rates.show-students', [$subject, $stage, $grade]) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Students
                </a>
                <button type="submit" class="btn btn-{{ $subject->subject == 'English' ? 'primary' : 'success' }}">
                    <i class="fas fa-save me-1"></i> Submit Rating
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    .rating > input {
        display: none;
    }
    .rating > label {
        position: relative;
        width: 1.5em;
        font-size: 2rem;
        color: #ddd;
        cursor: pointer;
    }
    .rating > label:hover,
    .rating > label:hover ~ label,
    .rating > input:checked ~ label {
        color: #ffd700;
    }
</style>
@endsection