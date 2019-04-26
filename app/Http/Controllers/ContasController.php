<?php

namespace App\Http\Controllers;

use App\Conta;
use Illuminate\Http\Request;

class ContasController extends Controller
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
            ['titulo' => 'Contas']
        ]);
        $listaDados = Conta::paginate(5);
  
        return view('contas', compact('listaMigalhas', 'listaDados'));
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
        
        $resul = Conta::create($data);
        if ($resul) {
            $request->session()->flash('success', 'Conta adicionada com sucesso!');
        }
        return redirect()->back();
    }

    public function show($id)
    {
        return Conta::findOrFail($id);
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
        
        $resul = Conta::find($id)->update($data);
        if ($resul) {
            $request->session()->flash('success', 'Conta atualizada com sucesso!');
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
        $res = Conta::find($id)->delete();
        if ($res) {
            $request->session()->flash('success', 'Conta apagada com sucesso!');
        } else {
            $request->session()->flash('error', 'Erro ao apagar conta!');
        }
        return redirect()->back();
    }
}
