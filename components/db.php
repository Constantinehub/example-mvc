<?php

class db
{
	public static function getConnection()
	{
		$paramsPath = ROOT . '/config/db_params.php';
		$params = include($paramsPath);

		$db = new PDO("mysql:dbname={$params['dbname']};host={$params['host']}", $params['user'], $params['password']);

		return $db;
	}
}