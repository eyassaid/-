<div class="m-3">
    <div class="input-group mb-4 shadow-sm rounded">
        <span class="input-group-text bg-white border-0">
            🔍
        </span>
        <input type="text" class="form-control border-0 shadow-none" 
               placeholder="البحث عن معلم" 
               wire:model.live='query' 
               style="border-radius: 20px;">
    </div>
    <em>عدد النتائج {{$teachers->count()}}</em>
    @forelse ($teachers as $teacher)
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="text-dark fw-bold">{{$teacher->name}}</h4>
                    <p class="text-muted">{{$teacher->balance}} الرصيد</p>
                    <div>
                        <a class="btn btn-outline-info btn-sm" href="{{ route('teacher.schedule.index', $teacher) }}">📅 رؤية الجدول</a>
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('teacher.absent.index', $teacher) }}">خيارات الغياب</a>
                    </div>
                </div>

                <hr>

                <div class="d-flex gap-3">
                    <button class="btn btn-outline-warning btn-sm" onclick="showEditForm({{ $teacher->id }})">✏️ تعديل</button>
                    <form action="{{ route('teacher.destroy', $teacher) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المعلم؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">🗑️ حذف</button>
                    </form>
                </div>

                <!-- Edit Form -->
                <div id="edit-form-{{ $teacher->id }}" style="display: none;" class="mt-3">
                    <form action="{{ route('teacher.update', $teacher) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name-{{ $teacher->id }}" class="form-label">اسم المعلم</label>
                            <input type="text" class="form-control" id="name-{{ $teacher->id }}" name="name" value="{{ $teacher->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="balance-{{ $teacher->id }}" class="form-label">الرصيد</label>
                            <input type="number" class="form-control" id="balance-{{ $teacher->id }}" name="balance" value="{{ $teacher->balance }}">
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">حفظ التغييرات</button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="hideEditForm({{ $teacher->id }})">إلغاء</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">
            <h4>لا يوجد معلم بهذا الاسم</h4>
        </div>
    @endforelse
</div>

<script>
    function showEditForm(id) {
        const form = document.getElementById('edit-form-' + id);
        if (form) {
            form.style.display = 'block'; // Show the form
        } else {
            console.error('Edit form not found for ID:', id);
        }
    }

    function hideEditForm(id) {
        const form = document.getElementById('edit-form-' + id);
        if (form) {
            form.style.display = 'none'; // Hide the form
        } else {
            console.error('Edit form not found for ID:', id);
        }
    }
</script>