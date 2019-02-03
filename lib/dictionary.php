<?php

function get_subject_pronouns(): array {
	return ['she', 'he', 'I', 'you'];
}

function get_fixer(): array {
	return ['looked', 'felt', 'seemed', 'became', 'appeared'];
}

function get_adjectives(): array {
	return ['giant', 'miniscule', 'bright', 'dull', 'hopeful', 
		'hungry', 'pretty', 'quiet', 'noisy', 'peaceful', 'boring', 
		'insane', 'wacky', 'frightened', 'sweet', 'perfect', 'amused', 
		'silly', 'changeable'];
}

function get_conjunctions(): array {
	return ['as', 'whilst', 'before', 'after', 'when'];
}

function get_verbs(): array {
	return ['opened', 'closed', 'borrowed', 'returned to', 'hoped for', 
		'needed', 'placed', 'added', 'removed', 'watched', 'ignored', 
		'laid down', 'picked up', 'wondered about', 'created', 'released', 
		'found', 'considered', 'pondered'];
}

function get_possessive_pronouns(): array {
	return ['the', 'their', 'our', 'his', 'her', 'a', 'my', 'your'];
}

function get_nouns(): array {
	return ['chair', 'house', 'car', 'horse', 'donkey', 'swimming pool', 
		'tree', 'cliff', 'piano', 'guitar', 'fish', 'ocean', 'bowl', 'plate', 
		'wand', 'hat', 'door', 'cinema', 'banana', 'treacle', 'pond'];
}

function get_dictionary(): array {
	return [
		get_subject_pronouns(), 
		get_fixer(), 
		get_adjectives(), 
		get_conjunctions(), 
		get_subject_pronouns(), 
		get_verbs(), 
		get_possessive_pronouns(), 
		get_adjectives(), 
		get_nouns()
	];
}
