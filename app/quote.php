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
	private $m_quote = [];

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
		$this->prepare_quote();
		return sprintf('The %s', $this->m_title);
	}

	/**
	 * Get a quote
	 * @return string - the quote or null on failure
	 */
	public function get_quote(): ?string {
		$this->prepare_quote();
		$rv = $this->get_formatted_quote();
		$this->reset_quote();
		return $rv;
	}

	/**
	 * Is there a quote currently saved?
	 * If not, create one
	 */
	private function prepare_quote() {
		if (empty($this->m_quote)) {
			$this->set_quote();
		}
	}

	/**
	 * Build and save a quote and title
	 */
	private function set_quote() {
		foreach ($this->get_dictionary() as $options) {
			$this->append_quote(static::choose($options));
		}
		$this->set_quote_title();
	}

	/**
	 * Clear the current quote
	 * @return none
	 */
	private function reset_quote() {
		$this->m_quote = [];
	}

	/**
	 * Push the next entry onto the end of the quote
	 * @return none
	 */
	private function append_quote(string $val) {
		$this->m_quote[] = $val;
	}

	/**
	 * Get a string version of the quote, formatted for output
	 * @return string - the formatted quote or null on failure
	 */
	private function get_formatted_quote(): ?string {
		$rv = null;
		$quote = static::purge($this->m_quote);
		if (!empty($quote)) {
			$rv = ucfirst(str_replace(' ,', ',', implode(' ', $quote)));
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
	 * Get the dictionary chapter pattern for a short quote
	 * @return array - the array keys for the required chapters
	 */
	private function get_quote_pattern_short(): array {
		return ['sub', 'fix', 'adj', 'subord', 'sub', 'verb', 'poss', 'adj', 'noun'];
	}

	/**
	 * Get the dictionary chapter pattern for a long quote
	 * @return array - the array keys for the required chapters
	 */
	private function get_quote_pattern_long(): array {
		return ['sub', 'fix', 'adj', 'coord', 'adj', 'subord', 'sub', 'verb', 'poss', 'adj', 'noun'];
	}

	/**
	 * Set the title for the current quote
	 * @return bool - true on success, false on failure
	 */
	private function set_quote_title(): bool {
		$filter_by_key = self::TITLE_KEY;
		$keys = array_keys($this->m_use_pattern, $filter_by_key);
		$key = array_pop($keys);
		$val = $this->m_quote[$key] ?? null;
		if (!empty($val)) {
			if ('verb' == self::TITLE_KEY) {
				$val = static::get_present_from_past($val);
			}
			$this->m_title = $val;
			return true;
		}
		return false;
	}

	/**
	 * Replace past tense verb with present participle
	 * @param string val - the verb to transform
	 * @return string - the transformed verb
	 */
	private static function get_present_from_past(string $val): ?string {
		$past_tense = '/^(\w+)ed[\s\w]*/';
		$present_participle = '$1ing';
		return preg_replace($past_tense, $present_participle, $val);
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
