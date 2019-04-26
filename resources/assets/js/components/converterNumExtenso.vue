<template>
            <input 
                v-model="this.numeroPorExtenso"
                class="form-control" type="text" style="min-width:500px;"
                v-bind:name="name" v-bind:id="id"/>
            
    
</template>

<script>
    export default {
        props:['valor','id','name'],
        created: function(){
            let numeroPorExtenso;
            let numero =  this.valor.replace(/[r$ ]/gi,'');
            this.numeroPorExtenso = this.toExtenso(numero);
            this.numeroPorExtenso = this.firstLetterToUpperCase(this.numeroPorExtenso);
        }, 
        data: function(){
        return { 
            dicionay:{
                0 : '',1 : 'um',2 : 'dois',3 : 'três',4 : 'quatro',5 : 'cinco',6 : 'seis',7 : 'sete',8 : 'oito',9 : 'nove',10 : 'dez',
                11 : 'onze',12 : 'doze',13 : 'treze',14 : 'quatorze',15 : 'quinze',16 : 'dezeseis',17 : 'dezesete',18 : 'dezoito',19 : 'dezenove',
                20 : 'vinte',30 : 'trinta',40 : 'quarenta',50 : 'cinquenta',60 : 'sessenta',70 : 'setenta',80 : 'oitenta',90 : 'noventa',
                100 : 'cem',200 : 'duzentos',300 : 'trezentos',400 : 'quatrocentos',500 : 'quinhentos',600 : 'seiscentos',700 : 'setecentos',800 : 'oitocentos',900 : 'novecentos',
                }
            }
        },
        methods:{
            toExtenso: function (num){
                if(num == '' || num == 0){
                    return '';
                }

                if(this.hasCharacter(num) != null){
                    return '';
                }

                num = num.toString();
               
                let valor = num.split(',');
                let reais = '';
                if(parseInt(valor[0]) > 0){
                    reais = valor[0].replace(/^0+/, '');
                    reais = this.fetchNumber(reais);
                    reais += ' reais';
                }
                let centavos ='';
                if(typeof valor[1] != 'undefined' && parseInt(valor[1]) > 0){
                    centavos = valor[1].replace(/^0+/, '');
                    centavos = centavos.slice(0,2);
                    centavos = this.fetchNumber(centavos);
                    
                    centavos += ' centavos';
                }
                if(reais != '' && centavos != ''){
                    return reais +' e '+ centavos;
                }else{
                    return reais + centavos;
                }
                
            },
            hasCharacter: function (n){
                n = n.replace(/\.|,/g,'');
                return n.match(/\D+/gi);
            },
            firstLetterToUpperCase: function(str){
                return str[0].toUpperCase() + str.slice(1);
            },
            fetchNumber: function(num){
                let res = this.dicionay[num];
                if(typeof res == 'undefined'){
                    //Numeros inteiros de duas casas (21 - 99)
                    if( num.length == 2){
                        res = this.dezenas(num);
                    }
                    //Numeros inteiros de três casas (101 - 999)
                    if( num.length == 3){
                        res = this.centenas(num);
                    }
                    //Numeros inteiros com mais que 3 casas (1000 - 999999)
                    if( num.length >3){
                        let inicio = num.slice(0,-3)
                        let final = num.slice(-3);
                        res = this.milhar(inicio,final);
                    }
                }
                return res;
            },
            roundNumber:function(num){
                let result = num[0];
                for(let i=1; i<num.length; i++){
                    result += '0'; 
                }
                return result;
            },
            unidades: function(num){
                return this.dicionay[num];
            },
            dezenas: function (num){
                let stringNumber = this.dicionay[num];
                if(typeof stringNumber != 'undefined'){
                    return stringNumber;
                }
                
                let dezena = 0;
                let d ;
                let u;
                if(num[0] != 0){
                    dezena = this.roundNumber(num);
                    d = this.dicionay[dezena];
                    u = this.unidades(num[1]);
                    stringNumber = d + ' e ' + u;
                }else{
                    u = this.unidades(num[1]);
                    stringNumber = u;
                }   
                
                return stringNumber;  
            },
            centenas: function (num){
                let stringNumber = this.dicionay[num];
                if(typeof stringNumber != 'undefined'){
                    return stringNumber;
                }
                
                let centena = 0;
                let d;
                let c;
                if(num[0] != 0){    
                    centena = this.roundNumber(num);
                    c = this.dicionay[centena];
                    d = this.dezenas(num[1]+num[2]);
                    if(c == 'cem' && d != ''){
                        c = 'cento';
                    }
                    stringNumber = c +' e '+ d;
                }else{
                    d = this.dezenas(num[1]+num[2]);
                    stringNumber = d;
                }
                
                return stringNumber; 
            },
            milhar: function (inicio,final){
                let milhar;
                
                if(inicio.length == 1){
                    milhar = this.unidades(inicio);
                }
                if(inicio.length == 2){
                    milhar = this.dezenas(inicio);
                }
                if(inicio.length == 3){
                    milhar = this.centenas(inicio);
                }
                let resto = '';
                if(final == 0){
                    return milhar+ ' mil ';
                }
                resto = this.centenas(final);
                let stringNumber = milhar+ ' mil e ' +resto;
                return stringNumber; 
            }
        }
    }
</script>
