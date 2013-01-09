<?php

class Create_Applications_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('applications', function($table){
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('name');
			$table->string('profile_identity')->nullable();
			$table->string('guid');
			$table->boolean('has_dist_build')->default(false);
			$table->timestamps();
			$table->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('applications');
	}

}