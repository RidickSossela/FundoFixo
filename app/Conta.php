<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    protected $fillable = [
        'conta', 'descricao',
    ];
    
    protected $table = 'contas';
    public $timestamps = false;

    
    public function item()
    {
        return $this->hasMany('App\Item');
    }
    
}
