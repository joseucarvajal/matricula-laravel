<div class="form-group {{ $errors->has('idDepartamento') ? 'has-error' : ''}}">
    <label for="idDepartamento" class="control-label">{{ 'Iddepartamento' }}</label>
    <select class="form-control" name="idDepartamento" required>
        @foreach ($departamentosArray as $departamento)
            <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>;
        @endforeach
    </select>
    {!! $errors->first('idDepartamento', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('nombre') ? 'has-error' : ''}}">
    <label for="nombre" class="control-label">{{ 'Nombre' }}</label>
    <input class="form-control" name="nombre" type="text" id="nombre" value="{{ $ciudad->nombre or ''}}" required>
    {!! $errors->first('nombre', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
