<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fundo Fixo - PDF</title>
</head>
<body>
    <table>
        <tr>
            <td class="departamento" colspan="2"> Divisao Produtos Florestais</td>
            <td class="fundo" colspan="3"> FUNDO FIXO </td> 
            <td class="anexo" colspan="2"> ANEXO II </td> 
        </tr>
        
        <tr>
            <td  colspan="7">
                <div class="desc-nr">
                    <div> Prestação de contas nr.: {{$fundofixo->nr}} - {{$fundofixo->ano}}</div>
                    <div> Unidade:   {{$fundofixo->unidade->fazenda}} </div>
                    <div> Funcionario Responsavel: {{$fundofixo->unidade->funcionario}} </div>
                    <div> Periodo de:   {{$fundofixo->periodoIni}} a  {{$fundofixo->periodoFim}} </div> 
                </div>
            </td>
        </tr>

        <tr>
            <td class="titulo-itens">DATA</td>
            <td class="titulo-itens">CONTA</td>
            <td class="titulo-itens">C.CUSTO</td>
            <td class="titulo-itens" colspan="3">DESCRIÇÃO DAS DESPESAS</td>
            <td class="titulo-itens">VALOR</td>
        </tr>
       
        
        @foreach ($itens as $item)
            <tr>
                <td class="bordas text-center"> {{$item->data}} </td>
                <td class="bordas text-center"> {{$item->conta->codigo}} </td>
                <td class="bordas text-center"> {{$item->ccusto->codigo}} </td>
                <td class="bordas text-justify" colspan="3" >NF. {{$item->notaFiscal}} - {{$item->descricao}} </td>
                <td class="bordas valor">  {{$item->valor}} </td>
            </tr>
        @endforeach
        <tr>
            <td class="border-bootom" colspan="7">&nbsp;</td>
        </tr>

        <tr>
            <td class="sem_dir" rowspan="3">Obs.</td>
            <td class="sem_esq" rowspan="3" colspan="4">descricao em texto</td>
            <td class="totals" >TOTAL DESPESAS</td>
            <td class="totals">R$ {{$fundofixo->valorTotal}} </td>
        </tr>
        <tr>
            <td class="totals" >VALOR FUNDO FIXO</td>
            <td class="totals">R$ 300,00</td>
        </tr>
        <tr>
            <td class="totals" >REEMBOLSO</td>
            <td class="totals"> R$ {{$fundofixo->valorTotal}} </td>
        </tr>

        <tr>
            <td class="bordas text-center" colspan="3">FUNCIONARIO</td>
            <td class="bordas text-center" colspan="2">CAP</td>
            <td class="bordas text-center">CONFERENCIA</td>
            <td class="bordas text-center">APROVAÇÃO</td>
        </tr>
        <tr>
            <td class="bordas" colspan="3">&nbsp;</td>
            <td class="bordas" colspan="2">&nbsp;</td>
            <td class="bordas">&nbsp;</td>
            <td class="bordas">&nbsp;</td>
        </tr>

    </table>
    
</body>
<style type="text/css"> 
    .bordas{
        border: 1px solid black;
    }
    table{
        white-space: nowrap;
        border-collapse: collapse;  
        border: 2px solid black;
        width: 100%;
        margin: auto;
    }
    td{
        width:auto;
        padding-left: 2px;
    }
    .fundo{
        font-size:20px;
        border-bottom: 2px solid black;
        border-top: 1px solid black;
        padding-left: 25%;
        text-align: center;
        font-style: italic;
        font-weight: bold;
    }
    .departamento{
        font-size: 10px;
        text-align: left;
        vertical-align: bottom;
        border-bottom: 2px solid black;
        border-top: 1px solid black;

    }
    .anexo{
        font-size: 12px;
        font-weight: bold;
        text-align: right;
        vertical-align: bottom;
        border-bottom: 2px solid black;
        padding-right: 5px;
    }
    .desc-nr{
        margin-left: 70px;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .titulo-itens{
        border-bottom: 1px solid black;
        border-top: 1px solid black;
        text-align: center;
    }
    .valor{
        text-align: center;
    }
    .totals{
        border: 1px solid black;
        text-align: center;
    }
    .text-center{
        text-align: center;
    }
    text-justify{
        text-align: justify;
    }
    .sem_esq{
        border-left: none;
        border-right: 1px  solid black;
        border-bottom:1px solid black;
        border-top:1px solid black;
        border-collapse: collapse;
    }
    .sem_dir{
        border-left: 1px  solid black;
        border-right: none;
        border-bottom:1px solid black;
        border-top:1px solid black;
    }
    .sem_lados{
        border-left: none;
        border-right: none;
        border-bottom:1px solid black;
        border-top:1px solid black;
        border-collapse: collapse;
    }
    .border-bootom{
        border-top:1px solid black;
        border-bottom:2px solid black;
    }

</style>


</html>