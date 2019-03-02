<template>
    <div>
      <div class="form-inline">
            <a v-if="criar && !modal" v-bind:href="criar">Criar</a>
            <modallink v-if="criar && modal" tipo="link" nome="adicionar" titulo="criar" css=""></modallink>
            <div class="form-group pull-right">
                <input v-if="pesquisa" type="search" class="form-control" placeholder="Buscar" v-model="buscar">
            </div>
        </div>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="cursor:pointer" v-on:click="ordenaColuna(index)" v-for="(titulo,index) in titulos">{{titulo}}</th>
                       
                        <th v-if="detalhe || editar || deletar">Ação</th>
                    </tr>
                </thead>

                <tbody>
                    <tr  v-for="(item,index) in lista">
                        <td v-for="i in item" >{{i | formataData(valor) }}</td>

                        <td v-if="detalhe || editar || deletar">
                            <form v-bind:id="index" v-if="deletar && token" v-bind:action="deletar + item.id" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" v-bind:value="token">


                                <a v-if="detalhe && !modal" v-bind:href="detalhe"> Detalhe</a>
                                <modallink v-if="detalhe && modal" v-bind:item="item" v-bind:url="detalhe" tipo="link" nome="detalhe" titulo="Detalhe" css=""></modallink> 
                                 
                                
                                <a v-if="editar && !modal" v-bind:href="editar"> Editar </a> |
                                <modallink v-if="editar && modal" v-bind:item="item" v-bind:url="editar" tipo="link" nome="editar" titulo="Editar" css=""></modallink> |


                                <a href="#" v-on:click="executaForm(index)">Deletar</a>
                                
                            </form>
                            <span v-if="!token">
                               <a v-if="detalhe && !modal" v-bind:href="detalhe"> Detalhe</a>
                                <modallink v-if="detalhe && modal" v-bind:item="item" v-bind:url="detalhe" tipo="link" nome="detalhe" titulo="Detalhe" css=""></modallink> 
                                 
                                <a v-if="editar && !modal" v-bind:href="editar"> Editar </a> |
                                <modallink v-if="editar && modal" tipo="link"  v-bind:item="item" v-bind:url="editar" nome="editar" titulo="Editar" css=""></modallink> |
                            </span>
                            <span v-if="token && !deletar">
                                <a v-if="detalhe && !modal" v-bind:href="detalhe"> Detalhe</a>
                                <modallink v-if="detalhe && modal" v-bind:item="item" v-bind:url="detalhe" tipo="link" nome="detalhe" titulo="Detalhe" css=""></modallink> 
                                 
                                <a v-if="criar && !modal" v-bind:href="editar"> Editar </a>|
                                <modallink v-if="criar && modal" tipo="link" v-bind:item="item"  v-bind:url="editar" nome="editar" titulo="Editar" css=""></modallink> |
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
    </div>
</template>


<script>
    export default {
        props:['titulos','itens','ordem','ordemcol', 'criar','detalhe','editar','deletar','token','modal','pesquisa'],
        data:function(){
           return {
               valor:"",
               buscar:"",
               ordemAux: this.ordem || "asc",
               ordemAuxCol: this.ordemcol || 0
           }
       },
       methods:{
           executaForm: function(index,){
               document.getElementById(index).submit();
           },
           ordenaColuna: function(coluna){
               this.ordemAuxCol = coluna;
               if(this.ordemAux.toLowerCase() == "asc"){
                   this.ordemAux = "desc";
               }else{
                   this.ordemAux = "asc"
               }
           }

       },
       filters: {
           formataData: function(valor){
               if(!valor) return '';
               valor = valor.toString();
               if(valor.split('-').length == 3){
                   valor = valor.split('-');
                   return valor[2] + '/'+ valor[1] + '/' + valor[0]
               }
               return valor;
           }
       },
       computed:{
           lista:function(){
               let ordem = this.ordemAux;
               let ordemcol = this.ordemAuxCol;
               ordem = ordem.toLowerCase();
               ordemcol = parseInt(ordemcol);

                if(ordem == "asc"){
                   this.itens.sort(function(a,b){
                   if(Object.values(a)[ordemcol] > Object.values(b)[ordemcol]){return 1;}
                   if(Object.values(a)[ordemcol] < Object.values(b)[ordemcol]){return -1;}
                   return 0;
                });
                }else{
                   this.itens.sort(function(a,b){
                   if(Object.values(a)[ordemcol] < Object.values(b)[ordemcol]){return 1;}
                   if(Object.values(a)[ordemcol] > Object.values(b)[ordemcol]){return -1;}
                   return 0;
               });
                }

                if(this.buscar){
                     return this.itens.filter(res => {
                         res = Object.values(res);
                   for(let k=0; k< res.length; k++){
                       if((res[k] + "").toLowerCase().indexOf(this.buscar.toLowerCase()) >= 0){
                       return true;
                    }
                }
                return false;
                    });
                }           
               return this.itens;
           }
       }
    }
</script>
