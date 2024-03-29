<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('url')->unique();
            $table->timestamps();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('id'); //unsigned solo acepta valores porsitivos 
            $table->foreign('category_id')->references('id')->on('categories') //el campo category_id hace referencia a el id de la tabla categories 
            ->onUpdate('cascade')
            ->onDelete('set null');  
        });  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign('projects_category_id_foreign');
            $table->dropColumn('category_id');

        });  
        Schema::dropIfExists('categories');
    }
}
