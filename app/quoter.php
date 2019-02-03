<?php
include_once('lib/dictionary.php');

class Quoter {
	const TITLE_KEY = 'noun';
	private $m_dictionary;
	private $m_title = 'fish';

	function __construct() {
		$this->m_dictionary = $this->get_dictionary();
	}

	public function get_title() {
		return sprintf('The %s', $this->m_title);
	}

	public function get_quote(): ?string {	
		$rv = null;
		$entries = $this->get_long_quote();
		$story = [];
		foreach ($entries as $entry) {
			$story[] = static::select_entry($entry);
		}	
		$this->set_long_quote_title($story);
		$rv = ucfirst(implode(' ', $story));
		return $rv;
	}

	private static function select_entry(array $entries): ?string {
		$max = count($entries) - 1;
		$index = rand(0, $max);
		return $entries[$index];
	}

	private function get_long_quote(): array {
		$pattern = ['sub', 'fix', 'adj', 'conj', 'sub', 'verb', 'poss', 'adj', 'noun'];
		return $this->get_dictionary_pattern($pattern);
	}

	private function set_long_quote_title(array $quote): void {
		$this->m_title = $quote[8];
	}

	private function get_dictionary_pattern(array $pattern): array {
		$rv = null;
		$dictionary = $this->m_dictionary;
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
