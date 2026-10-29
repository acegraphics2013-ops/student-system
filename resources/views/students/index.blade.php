@extends('layouts.app')
@section('title', 'Students List')

@section('content')
    <div class="p-3 p-md-5">
        <div class="table-responsive">
            <div class="card shadow-sm">
                <div class="card-header bg-white p-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h4 class="mb-0">Students</h4>
                    <div>
                        <x-button-link :href="route('students.create')" type="primary">Add Student</x-button-link>
                    </div>
                </div>

                <div class="card-body p-3">
                    @if(session('success'))
                        <x-alert-link type="success">
                            {{ session('success') }} Student Name: {{ session('student_name') }} Email: {{ session('student_email') }}
                        </x-alert-link>
                    @endif

                    @if(session('error'))
                        <x-alert-link type="danger">
                            {{ session('error') }}
                        </x-alert-link>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col" style="width: 60px;">Photo</th>
                                    <th scope="col" style="width: 100px;">Id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col" style="width: 220px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $student)
                                    <tr>
                                        <td>
                                            @if(!empty($student['photo']))
                                                <img src="{{ Storage::url($student['photo']) }}" alt="Photo" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $student['id'] }}</td>
                                        <td>{{ $student['name'] }}</td>
                                        <td>{{ $student['mail'] ?? '' }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <x-button-link :href="route('students.show', $student['id'])" type="info" class="btn-sm text-white">View</x-button-link>
                                                <x-button-link :href="route('students.edit', $student['id'])" type="warning" class="btn-sm">Edit</x-button-link>
                                                <form action="{{ route('students.destroy', $student['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete student: {{ $student['name'] }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-button-link type="danger" class="btn-sm">Delete</x-button-link>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <x-alert-link type="warning">No Data Found</x-alert-link>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection