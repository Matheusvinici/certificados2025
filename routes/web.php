<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\InscricaoController;
use App\Http\Controllers\FrequenciaController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\FormadorController;
use App\Http\Controllers\RelatorioController;

use Barryvdh\DomPDF\Facade as PDF;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    // Cursos Routes
    Route::resource('cursos', CursoController::class);
    Route::get('/teste-pdf', function () {
        $data = ['mensagem' => 'Teste de geração de PDF!'];
        $pdf = PDF::loadView('inscricoes.pdf', $data);
        return $pdf->download('teste.pdf');
    });

    Route::get('/relatorios/frequencia', [RelatorioController::class, 'filtroFrequencia'])->name('relatorios.frequencia');
Route::post('/relatorios/frequencia', [RelatorioController::class, 'gerarRelatorio'])->name('relatorios.frequencia.gerar');



    // Inscrição Routes (para exibir cursos e registrar inscrição)
    Route::resource('inscricoes', InscricaoController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('/relatorio/inscricoes', [InscricaoController::class, 'gerarRelatorioPDF'])->name('inscricoes.relatorio');

   // Rota para o formulário de registro de frequência
        Route::get('frequencias/create/{inscricaoId}', [FrequenciaController::class, 'create'])->name('frequencias.create');

        // Rota para salvar a frequência
        Route::post('frequencias/store/{inscricaoId}', [FrequenciaController::class, 'store'])->name('frequencias.store');

   
       
        
    // Certificados Routes
    Route::get('certificados', [CertificadoController::class, 'index'])->name('certificados.index');
    Route::get('certificados/create', [CertificadoController::class, 'create'])->name('certificados.create');
    Route::post('certificados/gerar', [CertificadoController::class, 'gerarCertificados'])->name('certificados.gerar');
    Route::get('certificados/{id}/pdf', [CertificadoController::class, 'gerarPdf'])->name('certificados.gerarPdf');

    // Formador Routes
    // Formador Routes
    Route::get('formador/index', [FormadorController::class, 'index'])->name('formador.index');

    // Rota para exibir os encontros do curso selecionado
    Route::get('formador/encontros', [FormadorController::class, 'encontros'])->name('formador.encontros');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
