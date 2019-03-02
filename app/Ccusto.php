<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ccusto extends Model
{
    protected $fillable = [
        'codigo', 'descricao',
    ];
    
    protected $table = 'ccustos';
    public $timestamps = false;

    
    public function item()
    {
        return $this->hasMany('App\Item');
    }
    
}
