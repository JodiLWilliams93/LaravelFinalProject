<form action="/admin/climb/{{ $climb['id'] }}/edit" method="post">
    <div class="form-group">
        <label for="name">Name of Route</label>
        <input type="text" name="climb[name]" id="name" value="{{ $climb['name'] }}">
    </div>
    <!--end .form-group -->
    <div class="form-group">
        <label for="description">Description of Route</label>
        <textarea name="climb[description]" id="description" rows='4' cols="50">{{ $climb['description'] }}</textarea>
    </div>
    <!--end .form-group -->
    <div class="form-group">
        <label for="rating">Rating</label>
        <input type="text" name="climb[rating]" id="rating" value="{{ $climb['rating'] }}">
    </div>
    <!--end .form-group -->
    <div class="form-group">
        <label for="length">Length (in meters)</label>
        <input type="text" name="climb[length]" id="length" value="{{ $climb['length'] }}">
    </div>
    <!--end .form-group -->
    <div class="form-group">
        <label for="type">Type</label>
        <select name="climb[type]" id="type">
            @foreach (['Sport', 'Trad', 'Top Rope', 'Boulder'] as $type)
            <option value="{{ $type }}" @if ($type==$climb['type']) {{ 'selected' }} @endif>{{ $type }}</option>
            @endforeach

        </select>
    </div>
    <!--end .form-group -->
    <div class="form-group">
        <label for="gear_needed">Gear Needed</label>
        <textarea name="climb[gear_needed]" id="gear_needed" rows='4' cols="50">{{ $climb['gear_needed'] }}</textarea>
    </div>
    <!--end .form-group -->
    <div class="form-group">
        <input type="submit" value="Update Route">
    </div>
    <!--end .form-group -->
</form>