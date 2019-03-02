<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTgrItensDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE 
            TRIGGER Tgr_Itens_Delete AFTER DELETE
            ON itens
            FOR EACH ROW BEGIN
            
            SELECT MIN(itens.data) from itens, fundofixos  where OLD.fundoFixos_id = fundofixos_id LIMIT 1 INTO @dataMin;
                UPDATE fundofixos SET periodoIni = @dataMin WHERE fundofixos.id = OLD.fundoFixos_id;
      
            SELECT MAX(itens.data) from itens where OLD.fundoFixos_id = fundofixos_id  LIMIT 1 INTO @dataMax;
                UPDATE fundofixos SET periodoFim = @dataMax WHERE fundofixos.id = OLD.fundoFixos_id;
  
            SELECT SUM(`valor`) FROM itens where OLD.fundoFixos_id = fundoFixos_id INTO @valorTotal;
                UPDATE fundofixos SET valorTotal = @valorTotal WHERE fundofixos.id = OLD.fundoFixos_id;
        END;
       ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
