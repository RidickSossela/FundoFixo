<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ItensController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validation = \Validator::make($request->input(),[
            'data' => 'required',
            'notaFiscal' => 'required',
            'descricao' => 'required',
            'valor' => 'required',
            'fundoFixos_id' => 'required',
            'contas_id' => 'required',
            'ccustos_id' => 'required',
       ]);
       if($validation->fails()){
           return redirect()->route('fundofixo.adicionaItem',$request->input('fundoFixos_id'))->withErrors($validation)->withInput();
       }
       if(Item::create($request->input())){
           $request->session()->flash('success','Item adicionado!');
       }else{
           $request->session()->flash('error', 'Erro ao adicionar item!');
       }
       return redirect()->route('fundofixo.adicionaItem',$request->input('fundoFixos_id'));
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return Item::findOrFail($item->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $validation = \Validator::make($request->input(),[
            'id' => 'required',
            'data' => 'required',
            'notaFiscal' => 'required',
            'descricao' => 'required',
            'valor' => 'required',
            'fundoFixos_id' => 'required',
            'contas_id' => 'required',
            'ccustos_id' => 'required',
       ]);
       if($validation->fails()){
           return redirect()->route('fundofixo.adicionaItem',$request->input('fundoFixos_id'))->withErrors($validation)->withInput();
       }
       if(Item::find($item->id)->update($request->input())){
           $request->session()->flash('success','Item atualizado com sucesso!');
       }else{
           $request->session()->flash('error', 'Erro ao atualizar item!');
       }
       return redirect()->route('fundofixo.adicionaItem',$request->input('fundoFixos_id'));
        
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Item $item)
    {
        {
            $res = Item::find($item->id)->delete();
            if ($res) {
                $request->session()->flash('success', 'Item apagado com sucesso!');
            } else {
                $request->session()->flash('error', 'Erro ao apagar item!');
            }   
            return redirect()->back();
        }
    }
}
