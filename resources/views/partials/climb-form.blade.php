<div class="form-group">
    <label for="name">Name of Route</label>
    <input type="text" name="name" id="name" value="{{  old('name', $climb['name']) }}">
</div>
<!--end .form-group -->
<div class="form-group">
    <label for="description">Description of Route</label>
    <textarea name="description" id="description" rows='4' cols="50">{{ old('description', $climb['description']) }}</textarea>
</div>
<!--end .form-group -->
<div class="form-group">
    <label for="rating">Rating</label>
    <input type="text" name="rating" id="rating" value="{{ old('rating', $climb['rating']) }}">
</div>
<!--end .form-group -->
<div class="form-group">
    <label for="length">Length (in feet)</label>
    <input type="text" name="length" id="length" value="{{ old('length', $climb['length']) }}">
</div>
<!--end .form-group -->
<div class="form-group">
    <label for="type">Type</label>
    <select name="type" id="type">
        @foreach (['Sport', 'Trad', 'Top Rope', 'Boulder'] as $type)
        <option value="{{ $type }}" @if ($type== old('type', $climb['type']) ) {{ 'selected' }} @endif>{{ $type }}</option>
        @endforeach

    </select>
</div>
<!--end .form-group -->
<div class="form-group">
    <label for="gear_needed">Gear Needed</label>
    <textarea name="gear_needed" id="gear_needed" rows='4' cols="50">{{ old('gear_needed', $climb['gear_needed']) }}</textarea>
</div>
<!--end .form-group -->