@extends('layout.app')



@section('title','اضافة معلم')

@section('content')

<form class="mt-3" action="{{route('teacher.store')}}" method="POST">
    @csrf
    <div class="mb-3">
        <label for='name' class="form-label">اسم المعلم</label>
        <input id='name' name='name' type="text" required>
    </div>
    <button class="btn btn-primary" type="sumbit">إضافة</button>
</form>

@endsection