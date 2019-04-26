<?php

namespace App\Http\Controllers;

use App\Ccusto;
use Illuminate\Http\Request;

class CcustosController extends Controller
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
            ['titulo' => 'C.Custos']
        ]);
        $listaDados = Ccusto::paginate(5);
        return view('ccustos', compact('listaMigalhas', 'listaDados'));
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
        $validation = \Validator::make($data, [
            'codigo' => 'required',
            'descricao' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }
        
        $resul = Ccusto::create($data);
        if ($resul) {
            $request->session()->flash('success', 'C.custo adicionada com sucesso!');
        } else {
            $request->session()->flash('error', 'Erro ao adicionar C.custo!');
        }
        return redirect()->back();
    }
    public function show($id)
    {
        return Ccusto::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conta  $conta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validation = \Validator::make($data, [
            'codigo' => 'required',
            'descricao' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }
        
        
        $resul = Ccusto::findOrFail($id)->update($data);

        if ($resul) {
            $request->session()->flash('success', 'Conta atualizada com sucesso!');
        } else {
            $request->session()->flash('error', 'Erro ao atualizar C.custo!');
        }
        return redirect()->back();
    }
       
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conta  $conta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $res = Ccusto::find($id)->delete();
        if ($res) {
            $request->session()->flash('success', 'Conta apagada com sucesso!');
        } else {
            $request->session()->flash('error', 'Erro ao apagar conta!');
        }
        return redirect()->back();
    }
}
