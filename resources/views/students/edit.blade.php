@extends('layouts.app')
@section('title', 'Edit Student')

@section('content')
    <div class="container p-2">
        <div class="row justify-content-center p-2">
            <div class="col-md-8 col-12">
                <div class="card p-4 shadow-sm">
                    <h3 class="mb-4">Edit Student</h3>

                    @if(session('error'))
                        <x-alert-link type="danger">
                            {{ session('error') }}
                        </x-alert-link>
                    @endif

                    <form action="{{ route('students.update', $student['id']) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Student Name</label>
                            <div>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $student['name']) }}" placeholder="Enter student name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                             <label for="mail" class="form-label">Email Address</label>
                             <div>
                                 <input type="email" name="mail" id="mail" class="form-control @error('mail') is-invalid @enderror" value="{{ old('mail', $student['mail'] ?? '') }}" placeholder="Enter email address">
                                 @error('mail')
                                     <div class="invalid-feedback">{{ $message }}</div>
                                 @enderror
                             </div>
                         </div>

                         <div class="mb-3">
                             <label for="photo" class="form-label">Student Photo (JPEG/PNG)</label>
                             <div>
                                 <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,image/gif">
                                 @if(!empty($student['photo']))
                                     <img src="{{ Storage::url($student['photo']) }}" alt="Current Photo" class="mt-2" style="max-width: 150px; max-height: 150px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                                 @endif
                                 @error('photo')
                                     <div class="invalid-feedback">{{ $message }}</div>
                                 @enderror
                             </div>
                         </div>
                        <div class="mb-3 d-flex gap-2">
                            <x-button-link type="primary">Update Student</x-button-link>
                            <x-button-link :href="route('students.index')" type="secondary">Cancel</x-button-link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection