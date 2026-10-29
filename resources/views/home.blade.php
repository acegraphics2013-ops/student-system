@extends('layouts.app')
@yield('title', 'Create and used an Alert Component')

@section('content')
    <div class="p-5">
        <x-alert-link type="success">Success!</x-alert-link>
    </div>
@endsection