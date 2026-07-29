<?php

use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\EncontroController;
use App\Http\Controllers\FormadorController;
use App\Http\Controllers\FrequenciaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InscricaoController;
use App\Http\Controllers\LeitorFrequenciaController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SecretariaController;
use App\Http\Controllers\UserController;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::put('user/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::resource('cursos', CursoController::class);

    Route::get('/teste-pdf', function () {
        $data = ['mensagem' => 'Teste de geração de PDF!'];
        $pdf = PDF::loadView('inscricoes.pdf', $data);

        return $pdf->download('teste.pdf');
    });

    Route::get('/relatorios/avaliacoes', [RelatorioController::class, 'filtroAvaliacoes'])->name('relatorios.avaliacoes');
    Route::post('/relatorios/avaliacoes', [RelatorioController::class, 'gerarRelatorio'])->name('relatorios.avaliacoes.gerar');

    Route::get('/frequencias', [FrequenciaController::class, 'index'])->name('frequencias.index');
    Route::get('/frequencias/pdf', [FrequenciaController::class, 'gerarPdf'])->name('frequencias.gerarPdf');
    Route::get('frequencias/create/{inscricaoId}', [FrequenciaController::class, 'create'])->name('frequencias.create');
    Route::post('frequencias/store/{inscricaoId}', [FrequenciaController::class, 'store'])->name('frequencias.store');
    Route::get('frequencias/verificar/{inscricaoId}', [FrequenciaController::class, 'verificar'])->name('frequencias.verificar');
    Route::put('frequencias/avaliar/{frequencia}', [FrequenciaController::class, 'avaliar'])->name('frequencias.avaliar');
    Route::get('inscricoes/{inscricao}/frequencias', [FrequenciaController::class, 'detalhes'])->name('inscricoes.frequencias');

    Route::delete('/inscricoes/{inscricao}', [InscricaoController::class, 'destroy'])->name('inscricoes.destroy');
    Route::resource('inscricoes', InscricaoController::class);
    Route::get('/relatorio/inscricoes', [InscricaoController::class, 'gerarRelatorioPDF'])->name('inscricoes.relatorio');
    Route::resource('inscricoes', InscricaoController::class);

    Route::get('certificados', [CertificadoController::class, 'index'])->name('certificados.index');
    Route::get('certificados/create', [CertificadoController::class, 'create'])->name('certificados.create');
    Route::post('certificados/gerar', [CertificadoController::class, 'gerarCertificados'])->name('certificados.gerar');
    Route::get('certificados/{id}/pdf', [CertificadoController::class, 'gerarPdf'])->name('certificados.gerarPdf');

    Route::get('/encontros', [EncontroController::class, 'index']);

    Route::get('formador/index', [FormadorController::class, 'index'])->name('formador.index');
    Route::get('formador/encontros', [FormadorController::class, 'encontros'])->name('formador.encontros');

    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('secretarias', SecretariaController::class);

    Route::get('leitor-frequencia', [LeitorFrequenciaController::class, 'index'])->name('leitor-frequencia.index');
    Route::get('leitor-frequencia/scan/{curso}', [LeitorFrequenciaController::class, 'scan'])->name('leitor-frequencia.scan');
    Route::post('leitor-frequencia/marcar', [LeitorFrequenciaController::class, 'marcarPresenca'])->name('leitor-frequencia.marcar');
});
