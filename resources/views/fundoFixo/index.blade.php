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
    
    <painel titulo="Lista de Fundo Fixos">
        <migalhas v-bind:lista="{{$listaMigalhas}}"></migalhas>
 
        <tabela-lista
        v-bind:titulos="['#', 'NR', 'Ano','Unidade']"
        v-bind:itens="{{json_encode($listaDados)}}"
        ordem="desc" ordem-col="0"
        criar="#criar" detalhe="fundofixo/" editar="fundofixo/" deletar="" token="{{ csrf_token() }}"
        modal="sim"
        
        ></tabela-lista>   
        <div align="center">
            {{$listaDados->links()}}
        </div>
    </painel>
</pagina>
<modal nome="adicionar" titulo="Adicionar">
    <formulario id="formAdicionar" css="" action="{{route('fundofixo.store')}}" method="post" enctype="" token="{{ csrf_token() }}">
        <div class="form-group">
            <label for="nr">NR</label>
            <input type="text" class="form-control" id="nr" name="nr" placeholder="nr" value="{{old('nr')}}">
        </div>
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

<modal nome="detalhe" titulo="Detalhe">
    <div class="text-center">
        <p> <h3> NR: @{{$store.state.item.nr}} - @{{$store.state.item.ano}}  </h3> </p>
        <p> <h3> Periodo: @{{$store.state.item.periodoIni? $store.state.item.periodoIni +" a "+ $store.state.item.periodoFim : "Não definido"}} </h3> </p>
        <p> <h3>Valor: @{{ $store.state.item.valorTotal || "Nao definido"}} </h3> </p>
    </div>
    <span slot="botoes">
        <a v-bind:href="'fundofixo/adiciona-item/'+ $store.state.item.id" class="btn btn-info">Editar Itens</a>
    </span>
</modal>
@endsection
