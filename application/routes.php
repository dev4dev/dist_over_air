<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

function result($status, $message = '')
{
	die(json_encode([
		'result' => $status,
		'message' => $message
	]));
}

Route::get('/', function()
{
	$apps = Application::all();
	return View::make('home.index', [
		'title' => 'Distribute Over Air',
		'apps' => $apps
	]);
});

Route::get('app/(:all)/download', ['as' => 'download', function($guid){
	$app = Application::where_guid($guid)->first();
	return View::make('home.download', [
		'title' => 'Download "'. $app->name .'" - DOA',
		'app' => $app
	]);
}]);

Route::post('upload/(:all)', function($guid) {
	# get app by guid
	$app = Application::where_guid($guid)->first();
	if (!$app) {
		result(false, 'Wrong app guid');
	}

	$data_dir = path('public') . 'files/' . $app->guid . '/';
	if (!file_exists($data_dir)) {
		mkdir($data_dir, 0777, true);
	}

	# Info.plist
	$info_file = Input::file('info');
	if (!$info_file) {
		result(false, 'No Info.plist file');
	}

	# store Info.plist
	try {
		Input::upload('info', $data_dir, 'Info.plist');
	} catch (Exception $e) {
		result(false, 'Error while uploading Info.plist file');
	}

	# convert to old xml style
	system("plutil -convert xml1 ${data_dir}info.plist");

	# read data from Info.plist
	$plist = new InfoPlist($data_dir . 'Info.plist');
	if (!$plist->processed()) {
		result(false, 'Error reading data from Info.plist');
	}
	$app->info_bundle_id = $plist->bundle_id;
	$app->info_display_name = $plist->display_name;
	$app->info_version = $plist->version;
	$app->save();

	# IPA
	$ipa_file = Input::file('ipa');
	if (!$ipa_file) {
		result(false, 'No .ipa file');
	}

	# store IPA file
	try {
		Input::upload('ipa', $data_dir, 'app.ipa');
	} catch (Exception $e) {
		result(false, 'Error while uploading .ipa file');
	}

	# return 'OK'
	result(true);
});

Route::get('test', function() {
	$user = User::find(1);

	if (!$user) {
		$user = User::create([
			'username' => 'admin',
			'password' => Hash::make('123')
			]);
	}

	Application::create([
		'user_id' => $user->id,
		'name' => 'My App',
		'guid' => md5(microtime())
	]);

	Application::create([
		'user_id' => $user->id,
		'name' => 'Test App',
		'guid' => md5(microtime())
	]);
});

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});