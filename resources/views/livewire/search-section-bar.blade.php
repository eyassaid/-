<div>
    <div class="input-group mb-4 shadow-sm rounded">
        <span class="input-group-text bg-white border-0">
            🔍
        </span>
        <input type="text" class="form-control border-0 shadow-none" 
               placeholder="البحث عن الصف" 
               wire:model.live='query' 
               style="border-radius: 20px;">
    </div>
    @forelse ($sections as $section)
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="text-dark fw-bold">{{ $section->name }}</h4>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-warning btn-sm" onclick="showEditForm({{ $section->id }})">✏️ تعديل</button>
                    <form action="{{ route('section.destroy', $section) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الصف؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">🗑️ حذف</button>
                    </form>
                </div>
            </div>

            <!-- نموذج التعديل -->
            <form id="edit-form-{{ $section->id }}" action="{{ route('section.update', $section) }}" method="POST" class="mt-3" style="display: none;">
                @csrf
                @method('PUT')
                <div class="input-group">
                    <input type="text" class="form-control" name="name" value="{{ $section->name }}" placeholder="تعديل الاسم">
                    <button type="submit" class="btn btn-success">💾 حفظ</button>
                    <button type="button" class="btn btn-secondary" onclick="hideEditForm({{ $section->id }})">❌ إلغاء</button>
                </div>
            </form>
        </div>
    </div>
@empty
    <div class="alert alert-info text-center">
        <h4>❗ لا يوجد صف!</h4>
    </div>
@endforelse
</div>
