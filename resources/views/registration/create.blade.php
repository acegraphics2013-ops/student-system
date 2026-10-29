@extends('layouts.app')

@section('title', 'Student Registration')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header border-0 text-white p-4" style="background: linear-gradient(135deg, #0d6efd, #6f42c1);">
                        <h1 class="h3 mb-1">Student Registration</h1>
                        <p class="mb-0 opacity-75">Fill in the details below to register a new student.</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        @if (session('success'))
                            <x-alert-link type="success" class="d-flex align-items-center">
                                <span class="me-2">&#10003;</span>
                                <span>{{ session('success') }}</span>
                            </x-alert-link>
                        @endif

                        @if (session('mail_failed'))
                            <x-alert-link type="warning">
                                The student was registered, but the confirmation email could not be sent.
                                Please check your mail settings.
                            </x-alert-link>
                        @endif

                        <form action="{{ route('registration.store') }}" method="POST" novalidate>
                            @csrf

                            <div class="row g-4">
                                <div class="col-12">
                                    <label for="name" class="form-label fw-semibold">Full Name</label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ old('name') }}"
                                        placeholder="e.g. Juan Dela Cruz"
                                        class="form-control form-control-lg @error('name') is-invalid @enderror"
                                        required
                                    >
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="email" class="form-label fw-semibold">Email Address</label>
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        value="{{ old('email') }}"
                                        placeholder="e.g. juan@example.com"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        required
                                    >
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-7">
                                    <label for="course" class="form-label fw-semibold">Course</label>
                                    <select
                                        name="course"
                                        id="course"
                                        class="form-select form-select-lg @error('course') is-invalid @enderror"
                                        required
                                    >
                                        <option value="" disabled {{ old('course') ? '' : 'selected' }}>Select a course</option>
                                        @foreach ([
                                            'BS Information Technology',
                                            'BS Computer Science',
                                            'BS Information Systems',
                                            'BS Accountancy',
                                            'BS Business Administration',
                                            'BS Civil Engineering',
                                            'BS Education',
                                        ] as $course)
                                            <option value="{{ $course }}" {{ old('course') === $course ? 'selected' : '' }}>
                                                {{ $course }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('course')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-5">
                                    <label for="year_level" class="form-label fw-semibold">Year Level</label>
                                    <select
                                        name="year_level"
                                        id="year_level"
                                        class="form-select form-select-lg @error('year_level') is-invalid @enderror"
                                        required
                                    >
                                        <option value="" disabled {{ old('year_level') ? '' : 'selected' }}>Select year</option>
                                        @foreach (['1' => '1st Year', '2' => '2nd Year', '3' => '3rd Year', '4' => '4th Year'] as $value => $label)
                                            <option value="{{ $value }}" {{ old('year_level') === $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('year_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-end">
                                <x-button-link type="primary" class="px-4">Register Student</x-button-link>
                            </div>
                        </form>
                    </div>
                </div>

                <p class="text-center text-muted small mt-3 mb-0">
                    A confirmation will be sent to the administrator's email address.
                </p>
            </div>
        </div>
    </div>
@endsection
