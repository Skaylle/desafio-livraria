<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RelatorioLivro;

class RelatorioController extends Controller
{
    public function gerarPDF()
    {
        $dados = RelatorioLivro::all()->groupBy('autor');

        $pdf = Pdf::loadView('pdf.relatorio', ['dados' => $dados]);

        return $pdf->download('relatorio_livros.pdf');
    }
}