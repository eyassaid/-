@extends('layout.app')

@section('title', isset($teacher) ? "جدول المعلم: $teacher->name" : "جدول القسم: $section->name")

@section('content')

<h1>{{ isset($teacher) ? "جدول المعلم: $teacher->name" : "جدول القسم: $section->name" }}</h1>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>اسم المعلم</th>
            <th>الحصة</th>
            <th>الصف</th>
            <th>اليوم</th>
            <th>الخيارات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($schedules as $schedule)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $schedule->teacher->name }}</td>
                <td>{{ $schedule->timeTable->class }}</td>
                <td>{{ $schedule->section->name }}</td>
                <td>{{ $schedule->timeTable->days }}</td>
                <td>

                    <form action="{{route('teacher.schedule.destroy',[$schedule->teacher,$schedule])}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">لا يوجد جدول متاح</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
