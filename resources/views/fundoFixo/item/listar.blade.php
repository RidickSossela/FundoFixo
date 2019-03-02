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
        v-bind:titulos="['#','Data', 'Conta','C.Custo','NF','Descrição das Despesas','Valor']"
        v-bind:itens="{{$itens}}"
        ordem="desc" ordemCol="0"
        criar="#criar" detalhe="" editar="../item/" deletar="../item/" token="{{ csrf_token() }}"
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
                    {{(old('contas_id') == $item->id)?$select = 'selected' : $select = ''}}
                    <option value="{{$item->id}}" {{$select}} >{{$item->codigo}} - {{$item->descricao}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="ccusto_id">C. Custos</label>
            <select class="form-control" name="ccustos_id" id="ccustos_id">
                <option value="">Selecione...</option>
                @foreach ($ccusto as $item)
                {{(old('ccustos_id') == $item->id)?$select = 'selected' : $select = ''}}
                    <option value="{{$item->id}}" {{$select}}>{{$item->codigo}} - {{$item->descricao}}</option>
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
            <label for="valor">Valor</label>
            <input type="text" class="form-control" id="valor" name="valor" placeholder="valor" value="{{old('valor')}}">
        </div>
        <input type="hidden" name="fundoFixos_id" value="{{$findofixos_id}}">
    </formulario>
    <span slot="botoes">
        <button form="formAdicionar" class="btn btn-info" >Adicionar</button>
    </span>
</modal>

<modal nome="editar" titulo="Editar">
    <formulario  id="formEditar" css="" v-bind:action="'../item/'+ $store.state.item.id" method="put"  token="{{ csrf_token() }}">
        <div class="form-group">
            <label for="data">data</label>
            <input type="date" class="form-control" id="data" name="data" placeholder="data" value="{{old('data')}}" v-model="$store.state.item.data">
        </div>
       <div class="form-group">
            <label for="conta">Conta</label>
           
            <select class="form-control" name="contas_id" id="contas_id" v-model="$store.state.item.contas_id">
                <option value="">Selecione...</option>
                @foreach ($conta as $item)
                    <option value="{{$item->id}}" {{$select}} >{{$item->codigo}} - {{$item->descricao}}</option>
                @endforeach
            </select>
        </div>  

        <div class="form-group">
            <label for="ccusto_id">C. Custos</label>
            <select class="form-control" name="ccustos_id" id="ccusto" v-model="$store.state.item.ccustos_id">
                <option value="">Selecione...</option>
                @foreach ($ccusto as $item)
                {{(old('ccustos_id') == $item->id)?$select = 'selected' : $select = ''}}
                    <option value="{{$item->id}}" {{$select}}>{{$item->codigo}} - {{$item->descricao}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="notaFiscal">Nota Fiscal</label>
            <input type="text" class="form-control" id="notaFiscal" name="notaFiscal" placeholder="notaFiscal" value="{{old('notaFiscal')}}" v-model="$store.state.item.notaFiscal">
        </div>
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" placeholder="descricao" value="{{old('descricao')}}" v-model="$store.state.item.descricao">
        </div>
        <div class="form-group">
            <label for="valor">Valor</label>
            <input type="text" class="form-control" id="valor" name="valor" placeholder="valor" value="{{old('valor')}}" v-model="$store.state.item.valor">
        </div>
        <input type="hidden" name="fundoFixos_id" value="{{$findofixos_id}}">
        <input type="hidden" name="id" v-model="$store.state.item.id">
    </formulario>
    <span slot="botoes">
        <button form="formEditar" class="btn btn-info" >Atualizar</button>
    </span>
</modal>
@endsection
