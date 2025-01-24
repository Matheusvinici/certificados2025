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
    HomeController
};
use Barryvdh\DomPDF\Facade as PDF;

// Rota inicial
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Rota para a página inicial autenticada
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {
    // Páginas estáticas
    Route::view('about', 'about')->name('about');

    // Gestão de Usuários
    Route::get('users', [UserController::class, 'index'])->name('users.index');

    // Gestão de Cursos
    Route::resource('cursos', CursoController::class);

    // Teste de geração de PDF
    Route::get('/teste-pdf', function () {
        $data = ['mensagem' => 'Teste de geração de PDF!'];
        $pdf = PDF::loadView('inscricoes.pdf', $data);
        return $pdf->download('teste.pdf');
    });

    // Relatórios
    Route::get('/relatorios/frequencia', [RelatorioController::class, 'filtroFrequencia'])->name('relatorios.frequencia');
    Route::post('/relatorios/frequencia', [RelatorioController::class, 'gerarRelatorio'])->name('relatorios.frequencia.gerar');

    // Frequências
    Route::get('/frequencias', [FrequenciaController::class, 'index'])->name('frequencias.index');
    Route::get('/frequencias/pdf', [FrequenciaController::class, 'gerarPdf'])->name('frequencias.gerarPdf');
    Route::get('frequencias/create/{inscricaoId}', [FrequenciaController::class, 'create'])->name('frequencias.create');
    Route::post('frequencias/store/{inscricaoId}', [FrequenciaController::class, 'store'])->name('frequencias.store');

    // Inscrições
    //Route::resource('inscricoes', InscricaoController::class)->only(['index', 'create', 'store', 'show']);
    Route::delete('/inscricoes/{inscricao}', [InscricaoController::class, 'destroy'])->name('inscricoes.destroy');
    Route::resource('inscricoes', InscricaoController::class);
    Route::get('/relatorio/inscricoes', [InscricaoController::class, 'gerarRelatorioPDF'])->name('inscricoes.relatorio');
    Route::resource('inscricoes', InscricaoController::class);

    // Certificados
    Route::get('certificados', [CertificadoController::class, 'index'])->name('certificados.index');
    Route::get('certificados/create', [CertificadoController::class, 'create'])->name('certificados.create');
    Route::post('certificados/gerar', [CertificadoController::class, 'gerarCertificados'])->name('certificados.gerar');
    Route::get('certificados/{id}/pdf', [CertificadoController::class, 'gerarPdf'])->name('certificados.gerarPdf');
 
    Route::get('/encontros', [EncontroController::class, 'index']);

    // Formador
    Route::get('formador/index', [FormadorController::class, 'index'])->name('formador.index');
    Route::get('formador/encontros', [FormadorController::class, 'encontros'])->name('formador.encontros');

    // Perfil do Usuário
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});
