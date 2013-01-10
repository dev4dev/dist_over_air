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
}

/**
* end of file
*/