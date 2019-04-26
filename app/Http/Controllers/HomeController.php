<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conta;
use App\Ccusto;
use App\Fundofixo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listaMigalhas = json_encode([
            ['titulo' => 'Home']
        ]);
    
        $caixaConta = [
                    'qtd' => Conta::count(),
                    'titulo' => 'Contas',
                    'url' =>  route('conta.index'),
                    'cor' => 'orange',
                    'icone' => 'icon ion-md-list'
        ];
        $caixaCcusto = [
            'qtd' => Ccusto::count(),
            'titulo' => 'C. Custos',
            'url' =>  route('ccusto.index'),
            'cor' => 'red',
            'icone' => 'icon ion-logo-buffer'
        ];
        $caixaFundofixo = [
            'qtd' => Fundofixo::count(),
            'titulo' => 'Fundo Fixo',
            'url' =>  route('fundofixo.index'),
            'cor' => 'green',
            'icone' => 'icon ion-md-filing'
        ];
        return view('home', compact('listaMigalhas', 'caixaConta', 'caixaCcusto', 'caixaFundofixo'));
    }
}
