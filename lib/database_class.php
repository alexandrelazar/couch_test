<?php
/**
*@package coaching
*@version 1.0
*@author gomelkuz@gmail.com
*
*Class implements database connection and queries using placeholders
*/

class DataBase {

	private $conn;
	private $sq = '?';
	private $prefix = 'coach_';
	
	protected function __construct($db_host, $db_user, $db_password, $db_name) {
		$this->conn = @new mysqli($db_host, $db_user, $db_password, $db_name);
		if ($this->conn->connect_errno) exit("Ошибка соединения с базой данных");
		$this->mysqli->query("SET lc_time_names = 'ru_RU'");
		$this->mysqli->set_charset("utf8");
	}

	/**
	*Simple method to get a placeholder
	*@return string placeholder
	*/

	public function getSQ() {
		return $this->sq;
	}
	
	/**
	*Method to get a safe SQL query row
	*
	*@param $query
	*@param $params
	*@return string
	*
	*/

	public function getQuery($query, $params) {
		if ($params) {
			$offset = 0;
			$len_sq = strlen($this->sq);
			for ($i = 0; $i < count($params); $i++) {
				$pos = strpos($query, $this->sq, $offset);
				if (is_null($params[$i])) $arg = "NULL";
				else $arg = "'".$this->conn->real_escape_string($params[$i])."'";
				$query = substr_replace($query, $arg, $pos, $len_sq);
				$offset = $pos + strlen($arg);
			}
		}
		return $query;
	}

	/**
	*Method to get array of result set
	*
	*@param $select
	*@return array
	*
	*/

	public function select(Select $select) {
		$result_set = $this->getResultSet($select, true, true);
		if (!$result_set) return false;
		$array = array();
		while (($row = $result_set->fetch_assoc()) != false)
			$array[] = $row;
		return $array;
	}

	/**
	*Method to get a single row in result set
	*
	*@param $select
	*@return array
	*
	*/

	public function selectRow(Select $select) {
		$result_set = $this->getResultSet($select, false, true);
		if (!$result_set) return false;
		return $result_set->fetch_assoc();
	}
	
	/**
	*Method to get a column from the table
	*
	*@param $select
	*@return array
	*
	*/

	public function selectCol(Select $select) {
		$result_set = $this->getResultSet($select, true, true);
		if (!$result_set) return false;
		$array = array();
		while (($row = $result_set->fetch_assoc()) != false) {
			foreach ($row as $value) {
				$array[] = $value;
				break;
			}
		}
		return $array;
	}
	
	/**
	*Method to get a single cell from a table
	*
	*@param $select
	*@return string
	*
	*/
	public function selectCell(Select $select) {
		$result_set = $this->getResultSet($select, false, true);
		if (!$result_set) return false;
		$arr = array_values($result_set->fetch_assoc());
		return $arr[0];
	}
	
	/**
	*Method to insert data to db
	*
	*@param $table_name
	*@param $row
	*@return bool
	*
	*/

	public function insert($table_name, $row) {
		if (count($row) == 0) return false;
		$table_name = $this->getTableName($table_name);
		$fields = "(";
		$values = "VALUES (";
		$params = array();
		foreach ($row as $key => $value) {
			$fields .= "`$key`,";
			$values .= $this->sq.",";
			$params[] = $value;
		}
		$fields = substr($fields, 0, -1);
		$values = substr($values, 0, -1);
		$fields .= ")";
		$values .= ")";
		$query = "INSERT INTO `$table_name` $fields $values";
		return $this->query($query, $params);
	}
	
	/**
	*Method to update existing data in the db
	*
	*@param $table_name
	*@param $row
	*@param $where
	*@param $params
	*@return bool
	*
	*/

	public function update($table_name, $row, $where = false, $params = array()) {
		if (count($row) == 0) return false;
		$table_name = $this->getTableName($table_name);
		$query = "UPDATE `$table_name` SET ";
		$params_add = array();
		foreach ($row as $key => $value) {
			$query .= "`$key` = ".$this->sq.",";
			$params_add[] = $value;
		}
		$query = substr($query, 0, -1);
		if ($where) {
			$params = array_merge($params_add, $params);
			$query .= " WHERE $where";
		}
		return $this->query($query, $params);
	}
	
	/**
	*Method to delete data from db
	*
	*@param $table_name
	*@param $where
	*@param $params
	*@return bool
	*
	*/

	public function delete($table_name, $where = false, $params = array()) {
		$table_name = $this->getTableName($table_name);
		$query = "DELETE FROM `$table_name`";
		if ($where) $query .= " WHERE $where";
		return $this->query($query, $params);
	}
	
	/**
	*SImple method to get a prefixed table name
	*
	*@param $table name
	*@return string
	*
	*/

	public function getTableName($table_name) {
		return $this->prefix.$table_name;
	}
	
	/**
	*Method to run a SQL query
	*
	*@param $query
	*@param $params
	*@return string
	*
	*/

	private function query($query, $params = false) {
		$success = $this->conn->query($this->getQuery($query, $params));
		if (!$success) return false;
		if ($this->conn->insert_id === 0) return true;
		return $this->conn->insert_id;
	}

	/**
	*Method to get a result set of running a SQL query
	*
	*@param $select
	*@param $zero
	*@param $one
	*@return bool||mysqli_result
	*
	*/
	
	private function getResultSet(Select $select, $zero, $one) {
		$result_set = $this->conn->query($select);
		if (!$result_set) return false;
		if ((!$zero) && ($result_set->num_rows == 0)) return false;
		if ((!$one) && ($result_set->num_rows == 1)) return false;
		return $result_set;
	}
	
	public function __destruct() {
		if (($this->conn) && (!$this->conn->connect_errno)) $this->conn->close();
	}
	
}

?>