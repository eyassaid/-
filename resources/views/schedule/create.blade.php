@extends('layout.app')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@section('title','تعيين حصة')

@section('content')
<h1>جدول الاستاذ: {{$teacher->name}}</h1>
<form class="mt-3" action="{{route('teacher.schedule.store',$teacher)}}" method="POST">
    @csrf
    <div class="mb-3">
        <label for='sections' class="form-label">اسم الصف</label>
        <select class="form-select"  name="section_id" >
            @foreach(\App\Models\Section::all() as $section)
            <option value="{{$section->id}}">{{$section->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for='classes' class="form-label">الحصة</label>
        <select size="8" class="form-select" multiple name="time_table_id[]" >
            @foreach($teacher->schedules()->freeClass() as $time_table)
            <option value="{{$time_table->id}}">{{$time_table->days}}:{{$time_table->class}}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-primary" type="submit">إضافة</button>
</form>

@endsection