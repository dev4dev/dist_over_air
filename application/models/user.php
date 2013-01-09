<?php

/**
* User Model
*/
class User extends Eloquent
{
	public function applications()
	{
		return $this->has_many('Application');
	}
}

/**
* end of file
*/