<div class="col-md-4">
        <label for="type" class="form-label">Prijs</label>
        <input
            type="number" class="form-control" name="type" id="type" value="{{ old('type') ? old('type') : $ring->type_id }}"
            placeholder=""
            @if($errors->has('type')) style="border-color: red;" @endif
        >
    </div>