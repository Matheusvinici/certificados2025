@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Servidores') }}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i> Novo Servidor
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="{{ route('users.index') }}" class="mb-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" placeholder="Pesquisar por nome..." value="{{ request()->query('search') }}">
                                    <button class="btn btn-primary" type="submit">Pesquisar</button>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>CPF</th>
                                            <th>Matrícula</th>
                                            <th>Email</th>
                                            <th>Função</th>
                                            <th>Secretaria</th>
                                            <th style="width: 180px">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <td class="fw-semibold">{{ $user->name }}</td>
                                            <td>{{ $user->cpf ? substr($user->cpf, 0, 3) . '.' . substr($user->cpf, 3, 3) . '.' . substr($user->cpf, 6, 3) . '-' . substr($user->cpf, 9, 2) : '-' }}</td>
                                            <td>{{ $user->matricula ?? '-' }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge bg-{{ $user->role == 'admin' ? 'primary' : ($user->role == 'formador' ? 'warning' : 'secondary') }} bg-opacity-10 px-3 py-1">
                                                    {{ $user->role }}
                                                </span>
                                            </td>
                                            <td>{{ $user->secretaria ?: '-' }}</td>
                                            <td>
                                                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Excluir servidor {{ $user->name }}?')">Excluir</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="7" class="text-center py-4 text-muted">Nenhum servidor encontrado.</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection