<template>
    <form v-bind:class="css" v-bind:action="action" v-bind:method="defineMethod" v-bind:enctype="enctype">
        <input v-if="alteraMethod"  type="hidden" name="_method" v-bind:value="method">
        <input v-if="token" type="hidden" name="_token" v-bind:value="token">
        <slot></slot>
    </form>
</template>

<script>
    export default {
        props:['css','action','method','enctype','token'],
        data: function(){
            return{
                alteraMethod: ""
            }
        },
        computed:{
            defineMethod:function(){
                if(this.method.toLowerCase() == "post" || this.method.toLowerCase() == "get"){
                    return this.method.toLowerCase();
                }
                if(this.method.toLowerCase() == "put" ){
                    this.alteraMethod = "put";
                }
                 if(this.method.toLowerCase() == "delete" ){
                    this.alteraMethod = "delete";
                }
                return "post";
            }
        }
    }
</script>
