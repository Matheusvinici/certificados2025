@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Editar Papel') }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('roles.update', $role->id) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="form-group">
                                <label for="name">Nome do Papel</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $role->name) }}" required>
                                @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <h5>Permissões</h5>
                            <div class="row">
                                @foreach($permissions as $group => $groupPermissions)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll_{{ $group }}" onchange="toggleGroup('{{ $group }}', this.checked)">
                                                <label class="form-check-label font-weight-bold" for="checkAll_{{ $group }}">{{ ucfirst($group) }}</label>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @foreach($groupPermissions as $perm)
                                            <div class="form-check">
                                                <input class="form-check-input group-{{ $group }}" type="checkbox" name="permissions[]" value="{{ $perm->name }}" id="perm_{{ $perm->id }}" {{ in_array($perm->name, $rolePermissions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="perm_{{ $perm->id }}">{{ $perm->name }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function toggleGroup(group, checked) {
    document.querySelectorAll('.group-' + group).forEach(cb => cb.checked = checked);
}
</script>
@endsection