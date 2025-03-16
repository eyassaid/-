@extends('layout.app')

@section('title', 'إدارة الصفوف')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">📚 قائمة الصفوف</h2>
        <a href="{{ route('section.create') }}" class="btn btn-primary shadow-sm">➕ إضافة صف جديد</a>
    </div>
    @livewire('search-section-bar')
    
</div>

<script>
    function showEditForm(id) {
        document.getElementById(`edit-form-${id}`).style.display = 'block';
    }
    function hideEditForm(id) {
        document.getElementById(`edit-form-${id}`).style.display = 'none';
    }
</script>

@endsection