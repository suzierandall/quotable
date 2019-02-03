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
		$entries = $this->get_dictionary();
		if (!empty($entries)) {
			$story = [];
			foreach ($entries as $entry) {
				$option = static::choose($entry);
				if (!empty($option)) {
					$story[] = $option;
				}
			}
			$this->set_long_quote_title($story);
			$rv = ucfirst(str_replace(' ,', ',', implode(' ', $story)));
		}
		return $rv;
	}

	private static function choose(array $options) {
		if (empty($options)) {
			return null;
		}
		$max = count($options) - 1;
		$index = rand(0, $max);
		return $options[$index];
	}

	private function populate_patterns() {
		$methods = get_class_methods($this);
		$pattern_methods = array_filter($methods, function($name) {
			return strpos($name, 'get_quote_pattern_') === 0;
		});
		$this->m_patterns = array_values($pattern_methods);
	}

	private function get_dictionary() {
		$rv = null;
		$pattern_callable = $this->choose($this->m_patterns);
		if (is_callable([$this, $pattern_callable])) {
			$pattern = $this->$pattern_callable();
			$rv = $this->get_dictionary_by_pattern($pattern);
		}
		return $rv;
	}

	private function get_quote_pattern_long(): array {
		return ['sub', 'fix', 'adj', 'comma', 'subord', 'sub', 'verb', 'poss', 'adj', 'noun'];
	}

	private function get_quote_pattern_longish(): array {
		return ['sub', 'fix', 'adj', 'coord', 'adj', 'comma', 'coord', 'sub', 'verb', 'poss', 'adj', 'noun'];
	}

	private function get_quote_pattern_longer(): array {
		return ['sub', 'fix', 'adj', 'coord', 'adj', 'comma', 'subord', 'sub', 'verb', 'poss', 'adj', 'noun'];
	}

	private function set_long_quote_title(array $quote): void {
		$this->m_title = $quote[8];
	}

	private function get_dictionary_by_pattern(array $pattern): array {
		$rv = null;
		$dictionary = $this->get_base_dictionary();
		foreach($pattern as $key) {
			$components = $dictionary[$key] ?? null;
			if (!is_null($components)) {
				$rv[] = $components;
			}
		}
		return $rv;
	}

	private function get_base_dictionary(): array {
		return [
			'sub' => get_subject_pronouns(),
			'poss' => get_possessive_pronouns(),
			'noun' => get_nouns(),
			'adj' => get_adjectives(),
			'verb' => get_verbs(),
			'fix' => get_fixer(),
			'coord' => get_coordinate_conjunctions(),
			'subord' => get_subordinate_conjunctions(),
			'comma' => [',']
		];
	}
}
