<div class="d-flex align-items-center gap-2">
    @if(!$edit)
        @if($teacher_id)
            <span class="fw-bold text-success">{{ \App\Models\Teacher::find($teacher_id)?->name }}</span>
            <button wire:click="$set('edit', true)" class="btn btn-sm btn-outline-primary">
                ✏️ تعديل
            </button>
        @else
            <div class="d-flex gap-2">
                <select wire:model="teacher_id" class="form-select form-select-sm w-auto">
                    <option value="">اختر المعلم</option>
                    @foreach(\App\Models\Schedule::freeTeachers($time_table_id) as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                    @endforeach
                </select>
                <button type="submit" wire:click="confirmSelection" class="btn btn-sm btn-success">
                    💾 حفظ
                </button>
            </div>
        @endif
    @else
        <div class="justify-content-center">
            <select wire:model="teacher_id" class="form-select form-select-sm w-auto  mt-2">
                <option value="">اختر المعلم</option>
                @foreach(\App\Models\Schedule::freeTeachers($time_table_id) as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                @endforeach
            </select>
            <button type="submit" wire:click="update" class="btn btn-sm btn-success">
                💾 حفظ
            </button>
            <button wire:click="$set('edit', false)" class="btn btn-sm btn-danger">
                ❌ إلغاء
            </button>
        </div>
    @endif
</div>
