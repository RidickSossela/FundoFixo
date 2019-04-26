<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Fundofixo extends Model
{
    protected $fillable = [
        'nr', 'ano','periodoIni','periodoFim','valorTotal','unidades_id'
    ];
    
    protected $table = 'fundofixos';
    public $timestamps = false;
    public $with = ['unidade','item'];
    
    public function unidade()
    {
        return $this->belongsTo('App\Unidade', 'unidades_id', 'id');
    }

    
    public function item()
    {
        return $this->hasMany('App\Item', 'fundofixos_id', 'id');
    }
    public static function buscaNr($id)
    {
        $data = DB::table('fundofixos')
        ->where('fundofixos.id', '=', $id)
        ->join('unidades', 'fundofixos.unidades_id', '=', 'unidades.id')
        ->select(
            'fundofixos.id',
            'fundofixos.nr',
            'fundofixos.ano',
            'fundofixos.periodoIni',
            'fundofixos.periodoFim',
            'fundofixos.valorTotal',
            'unidades.fazenda',
            'unidades.funcionario'
        )
        ->get();

        return $data;
    }

    /**
     * Listar todos os Fundo fixos
     */
    public static function listarFundofixos(){
       return DB::table('fundofixos')
                                ->join('unidades', 'fundofixos.unidades_id', '=', 'unidades.id')
                                ->select('fundofixos.id', 'nr', 'ano', 'fazenda')
                                ->paginate(8);
    }
}
