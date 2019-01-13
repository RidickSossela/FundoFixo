<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItensTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'itens';

    /**
     * Run the migrations.
     * @table itens
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('data');
            $table->string('notaFiscal', 20);
            $table->string('descricao', 60);
            $table->double('valor');
            $table->unsignedInteger('fundoFixos_id');
            $table->unsignedInteger('contas_id');
            $table->unsignedInteger('ccustos_id');


            $table->foreign('fundoFixos_id')
                ->references('id')->on('fundoFixos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('contas_id')
                ->references('id')->on('contas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('ccustos_id')
                ->references('id')->on('ccustos')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
