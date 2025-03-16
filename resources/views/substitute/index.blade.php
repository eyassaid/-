@extends('layout.app')

@section('title', 'جدول الغياب - Livewire')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4 text-primary">📋 جدول الغياب - {{ $day }}</h2>

    @if($substitutions->isNotEmpty())
        <table class="table table-bordered table-striped text-center shadow">
            <thead class="table-dark">
                <tr>
                    <th>👨‍🏫 المعلم البديل</th>
                    <th>🏫 الصف</th>
                    <th>⌚ الحصة</th>
                    <th>📌 المعلم الغائب</th>
                </tr>
            </thead>
            <tbody>
                @foreach($substitutions as $substitution)
                    <tr>
                        <td class="fw-bold text-success">
                            <h4 id="teacher-name-{{ $substitution->id }}">{{ $substitution->teacher?->name ?? '—' }}</h4>

                            <div id="edit-form-{{ $substitution->id }}" class="d-none">
                                <form action="{{ route('substitute.update', $substitution) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="d-flex justify-content-center gap-2">
                                        <select name="teacher_id" class="form-select form-select-sm w-auto">
                                            <option value="">اختر المعلم</option>
                                            @foreach(\App\Models\Schedule::freeTeachers($substitution->timeTable->id) as $teacher)
                                                <option value="{{ $teacher->id }}" 
                                                    {{ $substitution->teacher?->id == $teacher->id ? 'selected' : '' }}>
                                                    {{ $teacher->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-success">💾 حفظ</button>
                                        <button type="button" class="btn btn-sm btn-secondary" onclick="toggleEdit({{ $substitution->id }})">❌ إلغاء</button>
                                    </div>
                                </form>
                            </div>

                            <button id="edit-btn-{{ $substitution->id }}" class="btn btn-sm btn-warning mt-2 {{ $substitution->teacher ? '' : 'd-none' }}" onclick="toggleEdit({{ $substitution->id }})">
                                ✏️ تعديل
                            </button>
                        </td>

                        <td>{{ $substitution->section->name }}</td>
                        <td class="fw-bold">{{ $substitution->timeTable->class }}</td>
                        <td class="fw-bold text-danger">{{ $substitution->absent->teacher->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-success text-center">
            ✅ لا يوجد معلمين غائبين اليوم.
        </div>
    @endif
</div>

<script>
    function toggleEdit(id) {
        let editForm = document.getElementById(`edit-form-${id}`);
        let editBtn = document.getElementById(`edit-btn-${id}`);
        let teacherName = document.getElementById(`teacher-name-${id}`);

        if (editForm.classList.contains('d-none')) {
            editForm.classList.remove('d-none');
            editBtn.classList.add('d-none');
            teacherName.classList.add('d-none');
        } else {
            editForm.classList.add('d-none');
            editBtn.classList.remove('d-none');
            teacherName.classList.remove('d-none');
        }
    }
</script>

@endsection
