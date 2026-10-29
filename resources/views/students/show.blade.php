@extends('layouts.app')
@section('title', 'Student Info')

@section('content')
    <div class="container p-2">
        <div class="row justify-content-center p-2">
            <div class="col-md-8 col-12">
                <div class="card p-4 shadow-sm">
                    <h3 class="mb-4">Student Details</h3>
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase fw-semibold">ID</label>
                        <div class="fs-5 fw-bold">{{ $student['id'] }}</div>
                    </div>
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-semibold">Student Name</label>
                        <div class="fs-5">{{ $student['name'] }}</div>
                    </div>
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-semibold">Email Address</label>
                        <div class="fs-5">{{ $student['mail'] ?? '' }}</div>
                    </div>
                    @if(!empty($student['photo']))
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-semibold">Student Photo</label>
                        <div>
                            <img src="{{ Storage::url($student['photo']) }}" alt="Student Photo" class="img-fluid" style="max-width: 250px; max-height: 250px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                    </div>
                    @endif
                    <div class="d-flex gap-2">
                        <x-button-link :href="route('students.edit', $student['id'])" type="warning">Edit</x-button-link>
                        <x-button-link :href="route('students.index')" type="secondary">Back to List</x-button-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection