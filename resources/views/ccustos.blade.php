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
    
    <painel titulo="Lista de C. Custos">
        <migalhas v-bind:lista="{{$listaMigalhas}}"></migalhas>
        
        <tabela-lista
        v-bind:titulos="['#', 'Codigo', 'Descrição']"
        v-bind:itens="{{json_encode($listaDados)}}"
        ordem="desc" ordemCol="0"
        criar="#criar" detalhe="" editar="ccusto" deletar="ccusto/" token="{{ csrf_token() }}"
        modal="sim"
        
        ></tabela-lista>   
        <div align="center">
            {{$listaDados->links()}}
        </div>
    </painel>
</pagina>
<modal nome="adicionar" titulo="Adicionar">
    <formulario id="formAdicionar" css="" action="{{route('ccusto.store')}}" method="post" enctype="" token="{{ csrf_token() }}">
        <div class="form-group">
            <label for="ccusto">C.custo</label>
            <input type="text" class="form-control" id="ccusto" name="ccusto" placeholder="ccusto" value="{{old('ccusto')}}">
        </div>
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descricao" value="{{old('descricao')}}">
        </div>
    </formulario>
    <span slot="botoes">
        <button form="formAdicionar" class="btn btn-info" >Adicionar</button>
    </span>
</modal>

<modal nome="editar" titulo="Editar">
    <formulario  id="formEditar" css="" v-bind:action="'ccusto/'+ $store.state.item.id" method="put"  token="{{ csrf_token() }}">
        <div class="form-group">
            <label for="ccusto">C. Custo</label>
            <input type="text" class="form-control" v-model="$store.state.item.ccusto" id="ccusto" name="ccusto" placeholder="ccusto">
        </div>
        <div class="form-group">
            <label for="descricao">Descricao</label>
            <input type="text" class="form-control" v-model="$store.state.item.descricao" id="descricao" name="descricao" placeholder="Descricao">
        </div>
    </formulario>
    <span slot="botoes">
        <button form="formEditar" class="btn btn-info">Atualizar</button>
    </span>
</modal>
@endsection
