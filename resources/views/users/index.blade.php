@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Servidores') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="alert alert-info">
                       Página de Servidores Cadastrados no Sistema de Certificados
                    </div>

                    <!-- Formulário de Pesquisa -->
                    <form method="GET" action="{{ route('users.index') }}">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search" placeholder="Pesquisar por nome" value="{{ request()->query('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Pesquisar</button>
                            </div>
                        </div>
                    </form>

                    <div class="card">
                        <div class="card-body p-0">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Ações</th> <!-- Adicionei a coluna de ações -->
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <!-- Botão de editar, redirecionando para a página de edição -->
                                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer clearfix">
                            {{ $users->links() }}
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
