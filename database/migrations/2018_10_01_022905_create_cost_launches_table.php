<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCostLaunchesTable.
 */
class CreateCostLaunchesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cost_launches', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cost_id');
            $table->foreign('cost_id')->references('id')->on('costs')
            	->onDelete('cascade')
            	->onUpdate('cascade');
            $table->date('date');
            $table->float('price',6,2);
            $table->text('observation')->nullable();
            $table->unsignedInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')
            	->onDelete('cascade')
            	->onUpdate('cascade');

            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cost_launches');
	}
}
