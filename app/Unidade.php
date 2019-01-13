<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $table = 'unidades';
    public $timestamps = false;

    
    public function fundofixo()
    {
        return $this->hasMany('App\Fundofixo');
    }
    
}
