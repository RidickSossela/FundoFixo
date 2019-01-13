@extends('layouts.app')

@section('content')
<pagina tamanho="10">
    <painel>
        <migalhas v-bind:lista="{{$listaMigalhas}}"></migalhas>
        
        <div class="row">
            <div class="col-md-4">
                <caixa qtd="{{$caixaConta['qtd']}}" titulo="{{$caixaConta['titulo']}}" url="{{$caixaConta['url']}}" cor="{{$caixaConta['cor']}}" icone="{{$caixaConta['icone']}}">
                </caixa>
            </div>
            <div class="col-md-4">
                    <caixa qtd="{{$caixaCcusto['qtd']}}" titulo="{{$caixaCcusto['titulo']}}" url="{{$caixaCcusto['url']}}" cor="{{$caixaCcusto['cor']}}" icone="{{$caixaCcusto['icone']}}">
                </caixa>
            </div>
            <div class="col-md-4">
                    <caixa qtd="{{$caixaFundofixo['qtd']}}" titulo="{{$caixaFundofixo['titulo']}}" url="{{$caixaFundofixo['url']}}" cor="{{$caixaFundofixo['cor']}}" icone="{{$caixaFundofixo['icone']}}">
                </caixa>
            </div> 
        </div>
    </painel>
</pagina>
@endsection
