<div class="form-group">
    <label for="name">Название:</label>
    <input type="text" class="form-control" id="name" name="name" value="{{isset($type) ? $type->name : null}}">
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Сохранить' }}">
</div>
