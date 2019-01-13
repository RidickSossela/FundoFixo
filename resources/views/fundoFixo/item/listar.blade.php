@extends('layouts.app')

@section('content')
<pagina tamanho="12">   
    <span>                 
            @if (session('alert'))
            <div class="alert alert-info">
                {{ session('alert') }}
            </div>
            @endif
            
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            
            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </span>
      
    <painel titulo="DADOS DO FUNDO FIXOS">
        <migalhas v-bind:lista="{{$listaMigalhas}}"></migalhas>
   
        <listaunica
        v-bind:titulos="['NR', 'Ano','Periodo Inicial','Periodo Final','Valor','Unidade','Funcionario']"
        v-bind:itens="{{$dadosNr}}"
        ordem="desc" ordemCol="0"
        criar="" detalhe="" editar="" deletar="" token="{{ csrf_token() }}"
        modal="sim"
        pesquisa=""
        ></listaunica>  
    </painel>
 
    <painel>
        <listaunica
        v-bind:titulos="['Data', 'Conta','C.Custo','Descrição das Despesas','Valor']"
        v-bind:itens="{{$itens}}"
        ordem="desc" ordemCol="0"
        criar="#criar" detalhe="#" editar="#" deletar="#" token="{{ csrf_token() }}"
        modal="sim"
        pesquisa="sim" 
        ></listaunica>      
    </painel>
</pagina>

<modal nome="adicionar" titulo="Adicionar Item">
    <formulario id="formAdicionar" css="" action="{{route('item.store')}}" method="post" enctype="" token="{{ csrf_token() }}">
        <div class="form-group">
            <label for="data">data</label>
            <input type="date" class="form-control" id="data" name="data" placeholder="data" value="{{old('data')}}">
        </div>
        <div class="form-group">
            <label for="conta">Conta</label>
            <select class="form-control" name="contas_id" id="contas_id">
                <option value="">Selecione...</option>
                @foreach ($conta as $item)
                    <option value="{{$item->id}}">{{$item->conta}} - {{$item->descricao}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="ccusto_id">C. Custos</label>
            <select class="form-control" name="ccustos_id" id="ccustos_id">
                <option value="">Selecione...</option>
                @foreach ($ccusto as $item)
                    <option value="{{$item->id}}">{{$item->ccusto}} - {{$item->descricao}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="notaFiscal">Nota Fiscal</label>
            <input type="text" class="form-control" id="notaFiscal" name="notaFiscal" placeholder="notaFiscal" value="{{old('notaFiscal')}}">
        </div>
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" placeholder="descricao" value="{{old('descricao')}}">
        </div>
        <div class="form-group">
            <label for="valor">Descrição</label>
            <input type="text" class="form-control" id="valor" name="valor" placeholder="valor" value="{{old('valor')}}">
        </div>
        <input type="hidden" name="fundoFixos_id" value="{{$findofixos_id}}">
    </formulario>
    <span slot="botoes">
        <button form="formAdicionar" class="btn btn-info" >Adicionar</button>
    </span>
</modal>

<modal nome="editar" titulo="Editar">
    <formulario  id="formEditar" css="" v-bind:action="'fundofixo/'+ $store.state.item.id" method="put"  token="{{ csrf_token() }}">
        <div class="form-group">
            <label for="nr">NR</label>
            <input type="text" class="form-control" id="nr" name="nr" v-model="$store.state.item.nr" placeholder="nr" value="{{old('nr')}}">
        </div>
        <div class="form-group">
            <label for="ano">Ano</label>
            <input type="text" class="form-control" v-model="$store.state.item.ano" id="ano" name="ano" placeholder="ano">
        </div>
    </formulario>
    <span slot="botoes">
        <button form="formEditar" class="btn btn-info">Atualizar</button>
    </span>
</modal>
@endsection
