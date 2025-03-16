@extends('layout.app')

@php
    $days =  ['Sunday'=>'الاحد', 'Monday'=>'الاثنين','Tuesday'=>'الثلاثاء','Wednesday'=> 'الاربعاء',
    'Thursday'=> 'الخميس'];
@endphp

@section('title', 'خيارات الغياب')

@section('content')

<div class="container mt-4">
    <h1 class="text-center text-primary">{{ $teacher->name }}</h1>

    {{-- جدول الغيابات --}}
    @if($teacher->absents->count() > 0)
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">سجل الغياب</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>اليوم</th>
                            <th>تاريخ الغياب</th>
                            <th>عدد الحصص</th>
                            <th>إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teacher->absents as $absent)
                            <tr>
                                <td class="fw-bold">{{ $absent->days }}</td>
                                <td>{{ $absent->date }}</td>
                                <td>{{ $teacher->schedules()->whereHas('timeTable', fn($query) => $query->where('days', $absent->days))->count() }}</td>
                                <td>
                                    <form action="{{ route('teacher.absent.destroy', ['teacher' => $teacher, 'absent' => $absent]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">❌ حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if(session()->has('خطأ'))
<div class="text-danger mt-2">
    {{session('خطأ')}}
</div>
@endif
    @else
        <div class="alert alert-info text-center mt-4">
            لا يوجد غيابات مسجلة لهذا المعلم.
        </div>
    @endif

    {{-- زر إضافة غياب --}}
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">إضافة غياب</h5>
        </div>
        <div class="card-body d-flex flex-wrap gap-2 justify-content-center">
            @foreach($days as $index=>$day)
                @php
                    $classCount = $teacher->schedules()->whereHas('timeTable', fn($query) => $query->where('days', $day))->get()->count();
                @endphp
                <button type="button" class="btn btn-outline-dark btn-sm" onclick="confirmAbsence('{{ $index }}','{{$day}}' ,{{ $classCount }})">
                    {{ $day }}
                </button>
            @endforeach
        </div>
    </div>
</div>

<!-- ✅ نافذة التأكيد (Bootstrap Modal) -->
<div class="modal fade" id="absenceModal" tabindex="-1" aria-labelledby="absenceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="absenceModalLabel">تأكيد تسجيل الغياب</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد من تسجيل غياب لهذا اليوم؟</p>
                <p><strong>اليوم:</strong> <span id="absenceDay"></span></p>
                <p><strong>عدد الحصص المتأثرة:</strong> <span id="classCount"></span></p>
            </div>
            <div class="modal-footer">
                <form id="absenceForm" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">✅ تأكيد</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">❌ إلغاء</button>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmAbsence(index,day, count) {
        document.getElementById('absenceDay').innerText = day;
        document.getElementById('classCount').innerText = count;
        document.getElementById('absenceForm').action = "{{ route('teacher.absent.store', ['teacher' => $teacher, 'day' => '__DAY__']) }}".replace('__DAY__', index);
        var absenceModal = new bootstrap.Modal(document.getElementById('absenceModal'));
        absenceModal.show();
    }
</script>

@endsection
