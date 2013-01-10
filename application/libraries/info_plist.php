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

	const VERSION_KEY = 'CFBundleVersion';
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
		$xml = new DOMDocument('1.0', 'UTF8');
		$xml->load($this->file);

		$xpath = new DOMXPath($xml);
		foreach ($this->parse_options as $var_name => $option_key) {
			$node = $xpath->query('//key[contains(., "'. $option_key .'")]/following-sibling::string');
			if ($node->length > 0) {
				$this->{$var_name} = $node->item(0)->nodeValue;
			}
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