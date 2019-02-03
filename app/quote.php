<?php
/**
 * Class Quote, creates nonsense quotes
 * @author Suzie Randall
 * @version 0.1
 */

include_once('lib/dictionary.php');

class Quote {
	const TITLE_KEY = 'verb';
	private $m_title = 'fish';
	private $m_patterns = [];
	private $m_use_pattern;

	/**
	 * Initialise the m_patterns list
	 */
	function __construct() {
		$this->populate_patterns();
	}

	/**
	 * Get a short title for the current quote
	 * @return string - title for the quote
	 */
	public function get_title(): string {
		return sprintf('The %s', $this->m_title);
	}

	/**
	 * Get a quote
	 * @return string - the quote or null on failure
	 */
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
			$this->set_quote_title($story);
			$rv = ucfirst(str_replace(' ,', ',', implode(' ', $story)));
		}
		return $rv;
	}

	/**
	 * Chooses one item from an indexed array
	 * @param array options - the array from which the item will be chosen
	 * @return mixed - the value of the chosen item
	 */
	private static function choose(array $options) {
		if (empty($options)) {
			return null;
		}
		$max = count($options) - 1;
		$index = rand(0, $max);
		return $options[$index];
	}

	/**
	 * Populate a list with the names of all of the quote pattern methods
	 * @return none
	 */
	private function populate_patterns() {
		$methods = get_class_methods($this);
		$this->m_patterns = static::purge($methods, 'static::is_patterned');
	}

	/**
	 * Is this method name one of the quote pattern methods?
	 * @param string name - the method name to check
	 * @return bool - true if it is a quote pattern method; false otherwise
	 */
	private static function is_patterned($name): bool {
		return strpos($name, 'get_quote_pattern_') === 0;
	}

	/**
	 * Get the dictionary chapters for a randomly chosen pattern
	 * Stores the chosen pattern for use elsewhere
	 * @return array - the dictionary chapters or null on failure
	 */
	private function get_dictionary(): ?array {
		$pattern_callable = $this->choose($this->m_patterns);
		$this->m_use_pattern = null;
		if (is_callable([$this, $pattern_callable])) {
			$pattern = $this->$pattern_callable();
			$this->m_use_pattern = $pattern;
		}
		return $this->get_dictionary_by_pattern();
	}

	/**
	 * Get the dictionary chapter pattern for a long quote
	 * @return array - the array keys for the required chapters
	 */
	private function get_quote_pattern_long(): array {
		return ['sub', 'fix', 'adj', 'subord', 'sub', 'verb', 'poss', 'adj', 'noun'];
	}

	/**
	 * Get the dictionary chapter pattern for a longish quote
	 * @return array - the array keys for the required chapters
	 */
	private function get_quote_pattern_longish(): array {
		return ['sub', 'fix', 'adj', 'coord', 'adj', 'comma', 'coord', 'sub', 'verb', 'poss', 'adj', 'noun'];
	}

	/**
	 * Get the dictionary chapter pattern for a longer quote
	 * @return array - the array keys for the required chapters
	 */
	private function get_quote_pattern_longer(): array {
		return ['sub', 'fix', 'adj', 'coord', 'adj', 'comma', 'subord', 'sub', 'verb', 'poss', 'adj', 'noun'];
	}

	/**
	 * Set the title for the current quote
	 * @param array quote - the quote, itemised by chapter
	 * @return void
	 */
	private function set_quote_title(array $quote): void {
		// @todo FIXME: key word positions should be set per pattern
		// what pattern is this?
		// find last position of TITLE_KEY
		// retrieve value
		$this->m_title = $quote[8];
	}

	/**
	 * Filters and re-indexes indexed arrays
	 * @param array vals - array to be purged
	 * @param string callback - optional callback to pass to array_filter
	 * @return array - the purged and reindexed array
	 */
	private static function purge(
		array $vals,
		string $callback = null
	): array {
		$vals = !empty($callback)
			? array_filter($vals, $callback)
			: array_filter($vals);
		return array_values($vals);
	}

	/**
	 * Get the required dictionary chapters for the requested quote pattern
	 * @return array - the dictionary chapters or null on failure
	 */
	private function get_dictionary_by_pattern(): ?array {
		$rv = null;
		// pattern of required chapter keys
		if (!empty($this->m_use_pattern)) {
			$vals = [];
			foreach($this->m_use_pattern as $key) {
				$vals[] = $this->get_dictionary_chapter($key);
			}
			$rv = static::purge($vals);
		}
		return $rv;
	}

	/**
	 * Get a specific dictionary chapter
	 * @param string key - the array key for the required chapter
	 * @return array - the dictionary chapter
	 */
	private function get_dictionary_chapter(string $key): ?array {
		static $dictionary;
		if (is_null($dictionary)) {
			$dictionary = $this->get_base_dictionary();
		}
		return $dictionary[$key] ?? null;
	}

	/**
	 * Get an associative array containing all of the dictionary chapters
	 * @return array - the dictionary chapters
	 */
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
