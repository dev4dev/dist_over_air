<?php

class Alter_Applications_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('applications', function($table){
			$table->unique('guid');
			$table->string('slug')->unique();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('applications', function($table){
			$table->drop_unique('applications_guid_unique');
			$table->drop_column('slug');
		});
	}

}