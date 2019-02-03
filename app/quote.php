<?php
include_once('lib/dictionary.php');

class Quote {
	private static function select_entry(array $entries): ?string {
		$max = count($entries) - 1;
		$index = rand(0, $max);
		return $entries[$index];
	}

	public static function get_quote(): ?string {	
		$rv = null;
		$entries = get_dictionary();
		$story = [];
		foreach ($entries as $entry) {
			$story[] = static::select_entry($entry);
		}	
		$rv = implode(' ', $story);

		return $rv;
	}

	public static function get_name() {
		return 'fish';
	}	
}
