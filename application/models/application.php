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
}

/**
* end of file
*/