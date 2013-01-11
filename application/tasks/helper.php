<?php

/**
* Helper
*/
class Helper_Task
{
	public function run($args)
	{
		$methods = array_map(function($item) {
			return $item == 'run' ? null : "* {$item}";
		}, get_class_methods(__CLASS__));
		echo implode("\n", $methods);
	}

	public function default_admin()
	{
		$user = User::find(1);

		if (!$user) {
			$user = User::create([
				'username' => 'admin',
				'password' => Hash::make('123')
				]);
		}
	}

	public function dummy_data()
	{
		self::default_admin();
		$user = User::find(1);
		Application::make($user->id, 'My App');
		Application::make($user->id, 'Test App');
	}
}

/**
* end of file
*/