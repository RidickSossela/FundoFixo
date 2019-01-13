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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listaMigalhas = json_encode([
            ['titulo' => 'Home', 'url' => route('home')],
            ['titulo' => 'Fundo Fixo']
        ]);
        $listaDados = DB::table('fundofixos')
                                ->join('unidades', 'fundofixos.unidades_id', '=', 'unidades.id')
                                ->select('fundofixos.id', 'nr', 'ano', 'fazenda')
                                ->paginate(8);
       
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
        //dd($data);
        $validation = \Validator::make($data, [
            'nr' => 'required',
            'ano' => 'required',
            'unidades_id' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }
        if (DB::table('fundofixos')->where('nr', $data['nr'])->count() ==0) {
            $res = Fundofixo::create($data);

            if ($res) {
                $request->session()->flash('success', 'Fundo fixo adicionada com sucesso!');
                return $this->show($res);
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
        $listaMigalhas = json_encode([
            ['titulo' => 'Home', 'url' => route('home')],
            ['titulo' => 'Fundo Fixo'],
            ['titulo' => 'itens']
        ]);
        $dadosNr = Fundofixo::buscaNr($fundofixo->id);
    //Remover o id para não mostrar na tabela
        $findofixos_id = $dadosNr['0']->id;
        unset($dadosNr['0']->id);

        $itens = Item::where('fundofixos_id','=',$fundofixo->id)->get();
        $conta = Conta::get();
        $ccusto = Ccusto::get();

        return view('fundofixo.item.listar', compact('listaMigalhas', 'dadosNr','itens','conta','ccusto','findofixos_id'));
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
            $request->session()->flash('success', 'Fundo Fixo apagad0 com sucesso!');
        } else {
            $request->session()->flash('error', 'Erro ao apagar Fundo Fixo!');
        }
        return redirect()->back();
    }
}
