@extends('layouts.app')

@section('content')
<div class="card">
    {{-- <div class="card-header">
        <h5>Edit Rating for {{ $rate->student->name }}</h5>
    </div> --}}
    <div class="card-body">
        <form action="{{ route('rates.update', $rate) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="subject_id" class="form-label">Subject</label>
                <select class="form-select" id="subject_id" name="subject_id" required>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ $rate->subject_id == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Rating</label>
                <div class="rating">
                    @for($i = 5; $i >= 1; $i--)
                        <input type="radio" id="star{{ $i }}" name="rate" 
                               value="{{ $i }}" {{ $rate->rate == $i ? 'checked' : '' }} required/>
                        <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                    @endfor
                </div>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Feedback</label>
                <textarea class="form-control" id="notes" name="notes" rows="3">{{ $rate->notes }}</textarea>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('students.show', $rate->student) }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Rating</button>
            </div>
        </form>
    </div>
</div>
@endsection