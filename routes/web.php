<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CursoController,
    EncontroController,
    InscricaoController,
    FrequenciaController,
    CertificadoController,
    FormadorController,
    RelatorioController,
    UserController,
    ProfileController,
    HomeController,
    RoleController,
    PermissionController
};
use Barryvdh\DomPDF\Facade as PDF;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::put('user/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::get('users', [UserController::class, 'index'])->name('users.index');

    Route::resource('cursos', CursoController::class);

    Route::get('/teste-pdf', function () {
        $data = ['mensagem' => 'Teste de geração de PDF!'];
        $pdf = PDF::loadView('inscricoes.pdf', $data);
        return $pdf->download('teste.pdf');
    });

    Route::get('/relatorios/frequencia', [RelatorioController::class, 'filtroFrequencia'])->name('relatorios.frequencia');
    Route::post('/relatorios/frequencia', [RelatorioController::class, 'gerarRelatorio'])->name('relatorios.frequencia.gerar');

    Route::get('/frequencias', [FrequenciaController::class, 'index'])->name('frequencias.index');
    Route::get('/frequencias/pdf', [FrequenciaController::class, 'gerarPdf'])->name('frequencias.gerarPdf');
    Route::get('frequencias/create/{inscricaoId}', [FrequenciaController::class, 'create'])->name('frequencias.create');
    Route::post('frequencias/store/{inscricaoId}', [FrequenciaController::class, 'store'])->name('frequencias.store');

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
});