<?php

function get_dictionary(): array {
	$subject = ['she', 'he', 'I', 'you'];
	$make_it_fit_verb = ['looked', 'felt', 'seemed', 
		'became', 'appeared'];
	$adjective = ['giant', 'miniscule', 'bright', 'dull', 'hopeful', 
		'hungry', 'pretty', 'quiet', 'noisy', 'peaceful', 'boring', 
		'insane', 'wacky', 'frightened', 'sweet', 'perfect', 'amused', 
		'silly', 'changeable'];
	$conjunction = ['as', 'whilst', 'before', 'after', 'when'];
	$verb = ['opened', 'closed', 'borrowed', 'returned to', 'hoped for', 
		'needed', 'placed', 'added', 'removed', 'watched', 'ignored', 
		'laid down', 'picked up', 'wondered about', 'created', 'released', 
		'found', 'considered', 'pondered'];
	$possessive = ['the', 'their', 'our', 'his', 'her', 'a', 'my', 'your'];
	$noun = ['chair', 'house', 'car', 'horse', 'donkey', 'swimming pool', 
		'tree', 'cliff', 'piano', 'guitar', 'fish', 'ocean', 'bowl', 'plate', 
		'wand', 'hat', 'door', 'cinema', 'banana', 'treacle', 'pond'];

	$entries = [
		$subject, 
		$make_it_fit_verb, 
		$adjective, 
		$conjunction, 
		$subject, 
		$verb, 
		$possessive, 
		$adjective, 
		$noun
	];

	return $entries;	
}
