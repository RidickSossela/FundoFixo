<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    protected $fillable = [
        'data', 'notaFiscal','descricao','valor','fundoFixos_id','contas_id','ccustos_id'
    ];
    
    protected $table = 'itens';
    public $timestamps = false;
    public $with = ['conta','ccusto'];
    
    
    public function fundofixo()
    {
        return $this->belongsTo('App\Fundofixo');
    }

    public function ccusto()
    {
        return $this->belongsTo('App\Ccusto','ccustos_id');
    }
    
    public function conta()
    {
        return $this->belongsTo('App\Conta','contas_id');
    }

    public static function buscaItens($id){
        $data = DB::table('itens')
                    ->where('fundofixos_id','=',$id)
                    ->paginate();
        return $data;
    }
    
    
        
}
