<template>
 <div v-bind:class="defineCor">
    <div v-if="titulo" class="panel-heading">{{titulo}}</div>

        <div class="panel-body">        
            <slot></slot>
        </div>
 </div>
</template>

<script>
    export default {
        props:['titulo','cor'],
        computed:{
            defineCor: function(){
                return "panel "+ (this.cor || "panel-default");
            }
        }
    }
</script>

<style media="screen">
    .blue{
    border-color: #0c5883;
    }

    .blue > .panel-heading {
    color: #fdfffd;
    background-color: #0c5883;
    border-color: #0c5883;
    }

    .orange{
    border-color: #ee640d;
    }

    .orange > .panel-heading {
    color: #fdfffd;
    background-color: #ee640d;
    border-color: #ee640d;
    }
</style>

