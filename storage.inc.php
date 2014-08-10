<?php
/**
* Horribly trivial key-value storage system, saves out to local disk.
*/

function game_store($key, $value) {
	$file = get_game_storage($key);
	$dir = dirname($file);
	if(!is_dir($dir)) {
		`mkdir -p $dir`;
	}
	file_put_contents($file, serialize($value));
}

function game_add($key, $value) {
	$result = false;
	$file = get_game_storage($key);
	if(!file_exists($key)) {
		$result = game_store($key, $value);
	}
	return $result;
}

function game_get($key, &$value) {
	$result = false;
	$file = get_game_storage($key);
	if(file_exists($file)) {
		$value = unserialize(file_get_contents($file));
		$result = true;
	}
	return $result;
}

function get_game_storage($key) {
	return "/var/game-storage/".APPLICATION_NAMESPACE."/$key.bin";
}