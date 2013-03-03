<?php

class DB {

	private $dbh = NULL;

	function __construct() {

		$dbconfig = Config::get_property($db['default']);

		$dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
		$username = $dbconfig['user'];
		$password = $dbconfig['pass'];
		try {
			$this->dbh = new PDO($dsn, $username, $password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		}
		catch (PDOException $e) {
			echo 'ERROR: ' . __LINE__ . $e->getMessage();
		}

	}

	function __destruct() {

		$this->dbh = NULL;

	}

	function create($data, $table) {

		foreach ($data as $key => $value) {
			$data[':'.$key] = $value;
			unset($data[$key]);
		}

		try {
			$sth = $dbh->prepare('INSERT INTO someTable VALUES(' . implode(',', array_keys($data)) . ')');
			foreach ($data as $key => $value) {
				$sth->bindParam($key, $value);
			}
			$sth->execute();
				
			return $sth->rowCount();
				
		} catch(PDOException $e) {
			echo 'ERROR: ' . __LINE__ . $e->getMessage();
		}

	}

	function update($id, $data, $table) {

		foreach ($data as $key => $value) {
			$set[] = $key . ' = :'. $key;
			$data[':'.$key] = $value;
			unset($data[$key]);
		}

		foreach ($id as $key => $value) {
			$where[] = $key . ' = :'. $key;
			$id[':'.$key] = $value;
			unset($id[$key]);
		}

		try {
			$sth = $pdo->prepare('UPDATE someTable SET ' . implode(',', $set) . ' WHERE ' . implode(',', $where));
			$data += $id;
			foreach ($data as $key => $value) {
				$sth->bindParam($key, $value);
			}
			$sth->execute();

			return $sth->rowCount();

		} catch(PDOException $e) {
			echo 'ERROR: ' . __LINE__ . $e->getMessage();
		}
	}

	function delete($data, $table) {

		foreach ($data as $key => $value) {
			$where[] = $key . ' = :'. $key;
			$data[':'.$key] = $value;
			unset($data[$key]);
		}

		try {
			$sth = $pdo->prepare('DELETE FROM ' . $table . ' WHERE ' . implode(',', $where));
			foreach ($data as $key => $value) {
				$sth->bindParam($key, $value);
			}
			$sth->execute();

			return $sth->rowCount();

		} catch(PDOException $e) {
			echo 'ERROR: ' . __LINE__ . $e->getMessage();
		}
	}

	function read($data, $table) {

		foreach ($data as $key => $value) {
			$where[] = $key . ' = :'. $key;
			$data[':'.$key] = $value;
			unset($data[$key]);
		}

		try {
			$sth = $pdo->prepare('SELECT * FROM ' . $table . ' WHERE ' . implode(',', $where));
			foreach ($data as $key => $value) {
				$sth->bindParam($key, $value);
			}
			$sth->execute();
				
			return $sth->fetchAll();

		} catch(PDOException $e) {
			echo 'ERROR: ' . __LINE__ . $e->getMessage();
		}
	}

}