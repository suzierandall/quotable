<?php
include_once('lib/dictionary.php');

class Quote {
	const TITLE_KEY = 'noun';
	private $m_title = 'fish';
	private $m_patterns = [];

	function __construct() {
		$this->populate_patterns();
	}

	public function get_title() {
		return sprintf('The %s', $this->m_title);
	}

	public function get_quote(): ?string {	
		$rv = null;
		$entries = $this->get_long_quote();
		$story = [];
		foreach ($entries as $entry) {
			$option = static::select_one($entry);
			if (!empty($option)) {
				$story[] = $option;
			}
		}	
		$this->set_long_quote_title($story);
		$rv = ucfirst(implode(' ', $story));
		return $rv;
	}

	private static function select_one(array $options) {
		if (empty($options)) {
			return null;
		}
		$max = count($options) - 1;
		$index = rand(0, $max);
		return $options[$index];
	}

	private function populate_patterns() {
		$methods = get_class_methods($this);
		$m_patterns = array_filter($methods, function($name) {
			return strpos($name, 'get_quote_pattern_') === 0;
		});
	}

	private function get_long_quote(): array {
		$pattern = ['sub', 'fix', 'adj', 'subord', 'sub', 'verb', 'poss', 'adj', 'noun'];
		return $this->get_dictionary_pattern($pattern);
	}

	private function set_long_quote_title(array $quote): void {
		$this->m_title = $quote[8];
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
			'fix' => get_fixer(),
			'coord' => get_coordinate_conjunctions(),
			'subord' => get_subordinate_conjunctions(),
		];
	}	
}
