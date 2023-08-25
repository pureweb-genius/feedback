<?php

namespace application\lib;

use PDO;
use PDOException;

class Db {

	protected $db;
	
	public function __construct() {
		$config = require 'application/config/db.php';
		$this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['name'].'', $config['user'], $config['password']);

    }

    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':' . $key, $val);
            }
        }
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->getCode() === '23000' && strpos($e->getMessage(), 'Duplicate entry') !== false) {
                echo "Ошибка: Такая запись уже существует.";
            } else {
                echo "SQL Error: " . $e->getMessage();
                echo "\nPDO Error Info: ";
                debug($stmt->errorInfo());
            }
        }
        return $stmt;
    }

	public function row($sql, $params = []) {
		$result = $this->query($sql, $params);
		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	public function column($sql, $params = []) {
		$result = $this->query($sql, $params);
		return $result->fetchColumn();
	}

    public function lastInsertId() {
        return $this->db->lastInsertId();
    }



}