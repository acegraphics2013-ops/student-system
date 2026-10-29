@extends('layouts.app')
@section('title', 'Add Student Form')

@section('content')
    <div class="container p-2">
        <div class="row justify-content-center p-2">
            <div class="col-md-8 col-12">
                <div class="card p-4 shadow-sm">
                    <h3 class="mb-4">Add Student</h3>

                    @if(session('error'))
                        <x-alert-link type="danger">
                            {{ session('error') }}
                        </x-alert-link>
                    @endif

                    <form action="{{ route('students.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Student Name</label>
                            <div>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                         <div class="mb-3">
                             <label for="mail" class="form-label">Email Address</label>
                             <div>
                                 <input type="email" name="mail" id="mail" class="form-control @error('mail') is-invalid @enderror">
                                 @error('mail')
                                     <div class="invalid-feedback">{{ $message }}</div>
                                 @enderror
                             </div>
                         </div>

                         <div class="mb-3">
                             <label for="photo" class="form-label">Student Photo (JPEG/PNG)</label>
                             <div>
                                 <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,image/gif">
                                 @error('photo')
                                     <div class="invalid-feedback">{{ $message }}</div>
                                 @enderror
                             </div>
                         </div>
                        <div class="mb-3 d-flex gap-2">
                            <x-button-link type="primary">Create Student</x-button-link>
                            <x-button-link :href="route('students.index')" type="secondary">Cancel</x-button-link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection