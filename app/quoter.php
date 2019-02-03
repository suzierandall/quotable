<?php
include_once('lib/dictionary.php');

class Quoter {
	private $m_dictionary;

	function __construct() {
		//$this->dictionary = get_dictionary();
	}

	private static function select_entry(array $entries): ?string {
		$max = count($entries) - 1;
		$index = rand(0, $max);
		return $entries[$index];
	}

	public function get_quote(): ?string {	
		$rv = null;
		//$entries = $this->dictionary;
		$entries = $this->get_long_quote();
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

	private function get_long_quote(): array {
		$pattern = ['sub', 'fix', 'adj', 'conj', 'sub', 'verb', 'poss', 'adj', 'noun'];
		return $this->get_dictionary_pattern($pattern);
	}

	private function get_dictionary_pattern(array $pattern): array {
		$rv = null;
		$dictionary = $this->get_dictionary();
		foreach($pattern as $key) {
			$words = $dictionary[$key] ?? null;
			if (!is_null($words)) {
				$rv[] = $words;
			}
		}
		return $rv;
	}

	private function get_dictionary(): array {
		return [
			'sub' => get_subject_pronouns(), 
			'poss' => get_possessive_pronouns(), 
			'noun' => get_nouns(),
			'adj' => get_adjectives(), 
			'verb' => get_verbs(), 
			'conj' => get_conjunctions(), 
			'fix' => get_fixer() 
		];
	}	
}
