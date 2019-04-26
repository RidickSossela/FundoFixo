<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundofixosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'fundoFixos';

    /**
     * Run the migrations.
     * @table fundoFixos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) {
            return;
        }
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('nr');
            $table->smallInteger('ano');
            $table->date('periodoIni')->nullable();
            $table->date('periodoFim')->nullable();
            $table->double('valorTotal')->nullable();
            $table->unsignedInteger('unidades_id');

            

            $table->foreign('unidades_id')
                ->references('id')->on('unidades')
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
