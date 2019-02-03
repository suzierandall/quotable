<?php
include_once('lib/dictionary.php');

class Quoter {
	private $m_dictionary;

	function __construct() {
		$this->dictionary = get_dictionary();
	}

	private static function select_entry(array $entries): ?string {
		$max = count($entries) - 1;
		$index = rand(0, $max);
		return $entries[$index];
	}

	public function get_quote(): ?string {	
		$rv = null;
		$entries = $this->dictionary;
		$story = [];
		foreach ($entries as $entry) {
			$story[] = static::select_entry($entry);
		}	
		$rv = implode(' ', $story);

		return $rv;
	}

	public function get_name() {
		return 'fish';
	}	
}
