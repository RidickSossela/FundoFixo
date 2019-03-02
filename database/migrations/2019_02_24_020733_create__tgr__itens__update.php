<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTgrItensUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE TRIGGER Tgr_Itens_Update AFTER UPDATE ON itens FOR EACH ROW 
        BEGIN
            
            SELECT MIN(itens.data) FROM itens WHERE NEW.fundoFixos_id = fundoFixos_id LIMIT 1 INTO @dataMin;
                UPDATE fundofixos SET periodoIni = @dataMin WHERE fundofixos.id = NEW.fundofixos_id;
        
            SELECT MAX(itens.data) FROM itens WHERE NEW.fundoFixos_id = fundoFixos_id  LIMIT 1 INTO @dataMax;
                UPDATE fundofixos SET periodoFim = @dataMax WHERE fundofixos.id = NEW.fundofixos_id;
        
            SELECT SUM(`valor`) FROM itens WHERE NEW.fundofixos_id = fundofixos_id INTO @valorTotal;
                UPDATE fundofixos SET valorTotal = @valorTotal WHERE fundofixos.id = NEW.fundoFixos_id;
        
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
