<?php

/**
* Info Plist Reader
*/
class InfoPlist
{
	private $file = null;
	private $processed = false;

	public $version = 0;
	public $bundle_id = '';
	public $display_name = '';

	const VERSION_KEY = 'CFBundleShortVersionString';
	const BUNDLE_ID_KEY = 'CFBundleIdentifier';
	const DISPLAY_NAME_KEY = 'CFBundleDisplayName';

	private $parse_options = [
		'version' => self::VERSION_KEY,
		'bundle_id' => self::BUNDLE_ID_KEY,
		'display_name' => self::DISPLAY_NAME_KEY
	];

	function __construct($file)
	{
		$this->file = $file;
		$this->readfile();
	}

	private function readfile()
	{
		$xml = simplexml_load_file($this->file);
		$keys = (array)$xml->dict->key;
		$values = (array)$xml->dict->string;
		foreach ($this->parse_options as $var_name => $option_key) {
			$index = array_search($option_key, $keys);
			$this->{$var_name} = (string)$values[$index];
		}

		$this->processed = true;
	}

	public function processed()
	{
		return $this->processed;
	}
}

/**
* end of file
*/