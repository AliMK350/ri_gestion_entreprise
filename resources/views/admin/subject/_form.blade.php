<div class="card-body">
    <div class="form-group">
        <label>Subject Name</label>
        <input type="text" class="form-control" name="name" required placeholder="Subject name" value="{{ old('name', $subject->name ?? '') }}">
    </div>
    <div class="form-group">
        <label>Type</label>
        <select name="type" class="form-control" required>
            <option value="" {{ old('type', $subject->type ?? '') == '' ? 'selected' : '' }}>Select type</option>
            <option value="Theory" {{ old('type', $subject->type ?? '') == 'Theory' ? 'selected' : '' }}>Theory</option>
            <option value="Practical" {{ old('type', $subject->type ?? '') == 'Practical' ? 'selected' : '' }}>Practical</option>
        </select>
    </div>
    <div class="form-group">
        <label>Class</label>
        <select name="by_class" class="form-control" required>
            <option value="" {{ old('by_class', $subject->by_class ?? '') == '' ? 'selected' : '' }}>Select class</option>
            @foreach ($getClass as $class)
                <option value="{{ $class->id }}" {{ old('by_class', $subject->by_class ?? '') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="0" {{ old('status', $subject->status ?? '0') == '0' ? 'selected' : '' }}>Active</option>
            <option value="1" {{ old('status', $subject->status ?? '') == '1' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
</div>
