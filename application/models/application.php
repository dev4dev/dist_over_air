<?php

/**
* Application Mode
*/
class Application extends Eloquent
{
	public function user()
	{
		return $this->belongs_to('User');
	}

	public function ipa_url()
	{
		return url('files/' . $this->guid . '/app.ipa');
	}

	public function manifest_url()
	{
		return URL::to_route('manifest', $this->guid);
	}

	public static function make($user_id, $name)
	{
		return self::create([
			'user_id' => $user_id,
			'name' => $name,
			'guid' => md5(microtime())
		]);
	}
}

/**
* end of file
*/