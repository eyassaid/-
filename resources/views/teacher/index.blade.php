@extends('layout.app')

@section('title', 'إدارة المعلمين')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">📚 قائمة المعلمين</h2>
        <a class="btn btn-primary" href="{{ route('teacher.create') }}">➕ إضافة معلم</a>
    </div>

    @livewire('search-bar')

   
@endsection
