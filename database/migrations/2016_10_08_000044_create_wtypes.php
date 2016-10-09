<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Wtype;

class CreateWtypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wtypes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->timestamps();
        });

        $type = new Wtype;
        $type->description = "Step skip at X axis";
        $type->save();

        $type = new Wtype;
        $type->description = "Step skip at Y axis";
        $type->save();

        $type = new Wtype;
        $type->description = "Step skip at Z axis";
        $type->save();

        $type = new Wtype;
        $type->description = "High extruder temperature";
        $type->save();

        $type = new Wtype;
        $type->description = "Low extruder temperature";
        $type->save();

        $type = new Wtype;
        $type->description = "Extruder not heating";
        $type->save();

        $type = new Wtype;
        $type->description = "Unknown Error";
        $type->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wtypes');
    }
}
