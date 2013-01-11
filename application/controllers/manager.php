<?php

/**
* Manager Controller
*/
class Manager_Controller extends Base_Controller
{
	public $restful = true;

	public function get_index()
	{
		$apps = Application::all();
		return View::make('manager.home', [
			'title' => 'Manager',
			'apps' => $apps
		]);
	}

	public function get_add()
	{
		return View::make('manager.add', [
			'title' => 'Add App',
			'error' => Session::get('error')
		]);
	}

	public function post_add()
	{
		$app_name = trim(Input::get('app_name'));
		if (!$app_name) {
			return Redirect::to_action('manager@add')->with('error', 'Write app name');
		}
		try {
			$app = Application::make(1, $app_name);
		} catch (Exception $e) {
			return Redirect::to_action('manager@add')->with('error', 'Try another name!');
		}

		return Redirect::to_action('manager');
	}

	public function get_delete($id)
	{
		Application::find($id)->delete();
		return Redirect::to('manager');
	}
}

/**
* end of file
*/