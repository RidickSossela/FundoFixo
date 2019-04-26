<?php

namespace App\Http\Controllers;

use App\Fundofixo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Unidade;
use App\Item;
use App\Conta;
use App\Ccusto;

class FundofixosController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listaMigalhas = json_encode([
            ['titulo' => 'Home', 'url' => route('home')],
            ['titulo' => 'Fundo Fixo',]
        ]);
        
        $listaDados = Fundofixo::listarFundofixos();
       
        return view('fundofixo/index', compact('listaMigalhas', 'listaDados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input();
        $data['ano'] =  date('Y');
        //Pega a unidade 1, pois so existe uma.
        $data['unidades_id'] = 1;

        $validation = \Validator::make($data, [
            'nr' => 'required',
            'ano' => 'required',
            'unidades_id' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }
        //verifica se não existe NR
        if (DB::table('fundofixos')->where('nr', $data['nr'])->count() ==0) {
            $res = Fundofixo::create($data);

            if ($res) {
                $request->session()->flash('success', 'Fundo fixo adicionada com sucesso!');
                return $this->adicionaItem($res->id);
            } else {
                $request->session()->flash('error', 'Erro ao adicionar Fundo fixo!');
            }
        } else {
            $request->session()->flash('error', 'Essa NR já existe!');
        }
        return redirect()->back();
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Fundofixo  $fundofixo
     * @return \Illuminate\Http\Response
     */
    public function show(Fundofixo $fundofixo)
    {
        /**
         * Verifica se o periodo inicial ou final não é NULL
         * Para que o metodo dateTime() não retor a data atual
         * OBS. Caso parametro do metodo dateTime() seja null, retorna data atual
         */
        if (!empty($fundofixo->periodoIni) || !empty($fundofixo->periodoFim)) {
            $fundofixo->periodoIni = $this->converterData($fundofixo->periodoIni);
            $fundofixo->periodoFim = $this->converterData($fundofixo->periodoFim);
        }
        return $fundofixo;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fundofixo  $fundofixo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
     
        if (DB::table('fundofixos')->where('nr', $data['nr'])->count() ==0) {
            $validation = \Validator::make($data, [
                'nr' => 'required',
                'ano' => 'required'
                ]);
            if ($validation->fails()) {
                return redirect()->back()->withError($validation)->withInput();
            }
                
            $resul = Fundofixo::find($id)->update($data);
            if ($resul) {
                $request->session()->flash('success', 'Fundo fixo atualizada com sucesso!');
            } else {
                $request->session()->flash('error', 'Erro ao atualizar Fundo fixo!');
            }
        } else {
            $request->session()->flash('error', 'Esta NR ja existe!');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fundofixo  $fundofixo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $res = Fundofixo::find($id)->delete();
        if ($res) {
            $request->session()->flash('success', 'Fundo Fixo apagado com sucesso!');
        } else {
            $request->session()->flash('error', 'Erro ao apagar Fundo Fixo!');
        }
        return redirect()->back();
    }

    /**
     * Redireciona para pagina de adicionar itens
     */

    public function adicionaItem($id)
    {
        $listaMigalhas = json_encode([
            ['titulo' => 'Home', 'url' => route('home')],
            ['titulo' => 'Fundo Fixo', 'url' => route('fundofixo.index')],
            ['titulo' => 'Itens']
        ]);
        
        $dadosNr = Fundofixo::buscaNr($id);
        
        //Remover o id para não mostrar na tabela
        $findofixos_id = $dadosNr['0']->id;
        unset($dadosNr['0']->id);
        
        //Formatar valores em moeda $
        $dadosNr['0']->valorTotal = $this->converterMoeda($dadosNr['0']->valorTotal);

        $itens = Item::listarItens($id);
    
        foreach ($itens as $value) {
            $value->valor =  $this->converterMoeda($value->valor);
        }
        
        $conta = Conta::get();
        $ccusto = Ccusto::get();

        
        return view('fundofixo.item.listar', compact('listaMigalhas', 'dadosNr', 'itens', 'conta', 'ccusto', 'findofixos_id'));
    }
    
    /**
     * Metodo para gerar PDF
     */
    public function gerarPdf(Fundofixo $fundofixo, Request $request)
    {
        $itens = Item::where('fundofixos_id', $fundofixo->id)->orderBy('data', 'asc')->get();
        
        foreach ($itens as $value) {
            $value->data = $this->converterData($value->data);
        }
        foreach ($itens as $value) {
            $value->valor =  $this->converterMoeda($value->valor);
        }

        $fundofixo->valorTotal = $this->converterMoeda($fundofixo->valorTotal);
        $fundofixo->periodoIni = $this->converterData($fundofixo->periodoIni);
        $fundofixo->periodoFim = $this->converterData($fundofixo->periodoFim);

        $totalExtenso = $request->input('total');
        
        return \PDF::loadView('fundoFixo/pdf', compact('fundofixo', 'itens', 'totalExtenso'))
        ->setPaper('a4', 'portrait')
        ->stream('nome-arquivo-pdf-gerado.pdf');
    }
    
    /**
     * Metodo para coverte data
     */
    public function converterData($date)
    {
        $newDate = new \DateTime($date);
        return $newDate->format('d/m/Y');
    }

    /**
     * Coverter para real
     */
    public function converterMoeda($valor)
    {
        return $valor =  substr_replace(number_format($valor, 2, ",", "."), "R$ ", 0, 0);
    }
    
}