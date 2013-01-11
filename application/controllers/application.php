<?php

/**
* Applications Controller
*/
class Application_Controller extends Base_Controller
{
	public $restful = true;

	public function get_download($guid)
	{
		$app = Application::where_guid($guid)->first();
		return View::make('home.download', [
			'title' => 'Download "'. $app->name .'" - DOA',
			'app' => $app
		]);
	}

	public function get_manifest($guid)
	{
		$app = Application::where_guid($guid)->first();
		if (!$app) {
			return Response::error('404');
		}

		return View::make('home.manifest', [
			'app' => $app
		]);
	}

	public function post_upload($guid)
	{
		header('Content-type: application/json');
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
	}
}

/**
* end of file
*/