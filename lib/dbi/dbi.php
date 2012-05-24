<?php

switch ($GLOBALS['DBType']) {
    case 'sqlite3':
		require_once ADODB_PATH. '/adodb.inc.php';
		break;
	default:
		require_once ADODB_PATH . '/adodb.inc.php';
        break;
}


function dbi_concat($db, $a_str) {
    switch ($db) {
        case 'mysqlt':
            $res = 'CONCAT(' . implode(',', $a_str) . ')';
            break;
        case 'postgres':
            $res = implode(' || ', $a_str);
            break;
        case 'ado_mssql':
            $res = implode(' + ', $a_str);
            break;
        default;
            $res = implode(' || ', $a_str);
    }
    return $res;

}




/*
USING ADODB4
For SQL Server with Unicode / UTF8 these changes must be made in ADODB:

adodb-ado.inc.php:
  var $charPage;
  to
  var $charPage = CP_UTF8; // 65001

adodb-ado_mssql.inc.php:
	add
	var $hasInsertID = true;
	after
	var $upperCase = 'upper';

*/

/**
  * This class offers database connectivity. You must create one instance for every database connection you need.
  * DO NOT TRANSLATE THIS FILE
  * @package DBI
  */
class DataBaseInterface {

  /** @var string always holds the last statement sent to the DB */
  var $lastSQL;

  /** @var string always holds last error */
  var $lastError;

  /** @var string Path to a file. If set, all queries are logged there. */
  var $logFile;

  /** @var int number of queries sent to database */
  var $queriesNumber;

  // holds the database link (this is an ADODB connection class)
  var $_dbiLink;

  // server settings
  var $_DBServer;
  var $_DBUser;
  var $_DBPass;
  var $_DBName;
  var $_DBType;

  // these are used by Actions
  var $_action;
  var $_table;
  var $_fldval;
  var $_condition;
  var $_order;
  var $_auditEnabled;
  var $_auditStatements;
  var $_auditDateInserted;
  var $_auditTableName;
  var $_auditRecordId;


  /**
    * Initialize variables
    */
  function DataBaseInterface() {
    $this->logFile = '';
    $this->queriesNumber = 0;
    $this->_dbiLink = -1;
    $this->_DBServer = '';
    $this->_DBUser = '';
    $this->_DBPass = '';
    $this->_DBName = '';
    $this->_DBType = '';
  }

  function _logQuery() {
    // php 5.2.9 Fixed bug #47037 (No error when using fopen with empty string). (Cristian Rodriguez R., Felipe)
    if($this->logFile)
      $fp = fopen($this->logFile, 'a');
    if ($fp) {
      $s = "[" . gmdate('Y-m-d H:i:s', mktime()) . "] " . $this->lastSQL . "\n";
      fwrite($fp, $s, sdf_strlen($s));
      fclose($fp);
    }
  }

  function LogSQL($enabled) {
    $this->_dbiLink->LogSQL($enabled);
  }

  /**
    * Connect to database. If no parameters are passed they are looked up in $GLOBALS
    * @param sting $server server address
    * @param sting $user username
    * @param sting $pass password
    * @param sting $name database to connect
    * @param sting $type database type (oci8, mysql, mysqlt etc) See ADODB docs for more types
    * @return boolean
    */
  function connect($server = '', $user = '', $pass = '', $name = '', $type = '') {
    // set server settings
    if ($server == '') {
      // if no parameters passed, search for global settings
      $this->_DBServer = $GLOBALS['DBServer'];
      $this->_DBUser   = $GLOBALS['DBUser'];
      $this->_DBPass   = $GLOBALS['DBPass'];
      $this->_DBName   = $GLOBALS['DBName'];
      $this->_DBType   = $GLOBALS['DBType'];
    } else {
      $this->_DBServer = $server;
      $this->_DBUser   = $user;
      $this->_DBPass   = $pass;
      $this->_DBName   = $name;
      $this->_DBType   = $type;
    }
    // connect
	switch ($this->_DBType) {
	    case 'sqlite3':
		    $r = $this->_dbiLink = NewADOConnection('pdo');
		    if ($r) {
		    	$connstr='sqlite' . ':' . $this->_DBName;
		    	$r = $this->_dbiLink->Connect($connstr);		
		    }
	        break;
	    default:
		    $r = $this->_dbiLink = NewADOConnection($this->_DBType);
		    if ($r) {
				$r = $this->_dbiLink->Connect($this->_DBServer, $this->_DBUser, $this->_DBPass, $this->_DBName);
		      	if ($this->_DBType == 'mysqlt')
		        	$this->select('set names utf8');
		    }
	}    
   
    return $r;
  }

  /**
    * disconnect from database
    * @return boolean
    */
  function disconnect() {
    // close connection, reset vars
    $this->_dbiLink->Close();
    $this->_dbiLink = -1;
    $this->_DBServer = '';
    $this->_DBUser = '';
    $this->_DBPass = '';
    $this->_DBName = '';
    $this->_DBType = '';

    return true;
  }

  /**
    * make a select query, return results in array
    * @param string $sql query to execute
    * @param string $type 'num' for numeric indices only, 'assoc' for associative indices only, 'both' for both
    * @return mixed array with results or false on failure
    */
  function select($sql, $type = 'both') {
    $arr = array();
    $result = $this->_query($sql);
    if (!$result) return false;
    while ($row = $this->_fetchArray($result, $type))
      array_push($arr, $row);
    $this->_freeResult($result);
    return $arr;
  }

  /**
    * Make a query to the DB and return an array, limiting results.
    * This will return $num_rows records starting from $offset
    * $TotalRecords will return the TOTAL number of records for the specific $Where statement passed.<br>
    * @param string $sql select statement
    * @param integer $num_rows maximum number of records to return
    * @param integer $offset number of rows to jump
    * @param string $type 'num' for numeric indices only, 'assoc' for associative indices only, 'both' for both
    * @return mixed array with results or false on error
    */
  function selectLimit($sql, $num_rows, $offset, $type = 'both') {
    $arr = array();

    $result = $this->_dbiLink->selectLimit($sql, $num_rows, $offset);
    $this->lastError = $this->_dbiLink->ErrorMsg();
    $this->lastSQL = $sql;
    $this->queriesNumber++;
    $this->_logQuery();

    if (!$result) return false;
    while ($row = $this->_fetchArray($result, $type))
      array_push($arr, $row);
    $this->_freeResult($result);
    return $arr;
  }

  /**
    * Quote string for insertion into the DB
    * e.g. "Tom's PC" will become "'Tom''s PC'" for access/mssql/oracle and "'Tom\'s PC'" for mysql
    * @param string $s the string to quote
    * @return string quoted string, or NULL if $s is empty or null
    */
  function qstr($s) {
    if ((is_null($s)) || (sdf_strlen($s) == ''))
      return 'NULL';
    else
      return $this->_dbiLink->qstr($s, false);
  }

  /**
    * Quote (prepare) integer for insertion into the DB. This will convert $s to integer.
    * @param mixed $i the integer to quote
    * @return mixed integer or the string NULL if $i is empty or null
    */
  function qint($i) {
    if ((is_null($i)) || (sdf_strlen($i) == ''))
      return 'NULL';
    else
      return (int)$i;
  }

  /**
    * Quote (prepare) decimal/float for insertion into the DB. This will replace comma (,) with dot (.)
    * @param midex $d the decimal to quote
    * @return mixed decimal (as string), or the string NULL if $d is empty or null
    */
  function qdec($d) {
    if ((is_null($d)) || (sdf_strlen($d) == ''))
      return 'NULL';
    else {
      $cd = str_replace(',' , '.', $d); // replace comma with dot
      $cd = (float)$d; // convert to float
      return $d;
    }
  }

  /**
    * begin a transaction
    * @return boolean
    */
  function beginTrans() {
    $res = $this->_dbiLink->BeginTrans();

    return $res;
  }

  /**
    * commit a transaction
    * @return boolean
    */
  function commitTrans() {
    $res = $this->_dbiLink->CommitTrans();

    return $res;
  }

  /**
    * rollback a transaction
    * @return boolean
    */
  function rollbackTrans() {
    $res = $this->_dbiLink->RollbackTrans();

    return $res;
  }

  /**
    * is transaction active
    * @return boolean true if transaction is opened, false otherwise
    */
  function inTrans() {
    if ($this->_dbiLink->transCnt > 0)
      return true;
    else
      return false;
  }

  /**
    * returns an empty clob string
    * @return string
    */
  function emptyClob() {
    if ($this->_DBType == 'oci8')
      return 'empty_clob()';
    else
      return 'NULL';
  }

  /**
    * updates $column in $table (must be CLOB) with $val where $where
    * @param string $table the table with the clob
    * @param string $column the column
    * @param string $val the value to be inserted
    * @param string $where where statement for updating correct row
    * @return boolean
    */
  function updateClob($table, $column, $val, $where) {
    $res = $this->_dbiLink->UpdateClob($table, $column, $val, $where);
    $this->lastError = $this->_dbiLink->ErrorMsg();
    $this->queriesNumber++;
    return $res;
  }

  /**
    * returns an empty blob string
    * @return string
    */
  function emptyBlob() {
    if ($this->_DBType == 'oci8')
      return 'empty_blob()';
    else
      return 'NULL';
  }

  /**
    * updates $column in $table (must be BLOB) with $val where $where
    * @param string $table the table with the blob
    * @param string $column the column
    * @param string $val the value to be inserted
    * @param string $where where statement for updating correct row
    * @return boolean
    */
  function updateBlob($table, $column, $val, $where) {
    $res = $this->_dbiLink->UpdateBlob($table, $column, $val, $where);
    $this->lastError = $this->_dbiLink->ErrorMsg();
    $this->queriesNumber++;
    return $res;
  }

  /**
    * returns the field name with the correct function of every DB in order to make it UpperCase.
    * e.g. for ORACLE uppercase('lastname') will return the string: uppercase(lastname).
    * @param string $field the field to prepare
    * @return string proper sql statement for getting uppercased string from DB
    */
  function uppercase($field) {
    if ($this->_DBType == 'oci8')
      return 'upper(' . $field . ')';
    else
    if (sdf_substr($this->_DBType, 0, 5) == 'mysql')
      return 'upper(' . $field . ')';
    else
      return $field;
  }

  /**
    * initializes an Action (empties all private vars)
    * @return void
    */
  function _initAction() {
    $this->_action = '';
    $this->_table = $table;
    unset($this->_fldval);
    $this->_fldval = array();
    $this->_condition = '';
    $this->_order = '';
    $this->_auditStatements = array();
    $this->_auditDateInserted = today();
    $this->_auditTableName = '';
    $this->_auditRecordId = '';
  }

  /**
    * initiates a select operation
    * @param $table tablename
    * @return void
    */
  function newSelect($table) {
    $this->_initAction();
    $this->_action = 'select';
    $this->_table = $table;
  }

  /**
    * initiates an insert operation
    * @param $table string tablename
    * @param $audit boolean enable/disable audit
    * @return void
    */
  function newInsert($table, $audit = false) {
    $this->_initAction();
    $this->_action = 'insert';
    $this->_table = $table;
    $this->_auditEnabled = $audit;
    if ($this->_auditEnabled) {
      $this->_auditTableName = $table;
    }
  }

  /**
    * initiates an update operation
    * @param $table tablename
    * @param $audit boolean enable/disable audit
    * @param $record_id int the id of the record these changes affect
    * @return void
    */
  function newUpdate($table, $audit = false, $record_id = '') {
    $this->_initAction();
    $this->_action = 'update';
    $this->_table = $table;
    $this->_auditEnabled = $audit;
    if ($this->_auditEnabled) {
      $this->_auditTableName = $table;
      $this->_auditRecordId = $record_id;
    }
  }

  /**
    * initiates a delete operation
    * @param $table tablename
    * @param boolean $audit enable/disable audit
    * @param int $record_id the id of the record these changes affect
    * @return void
    */
  function newDelete($table, $audit = false, $record_id = '') {
    $this->_initAction();
    $this->_action = 'delete';
    $this->_table = $table;
    $this->_auditEnabled = $audit;
    if ($this->_auditEnabled) {
      $this->_auditTableName = $table;
      $this->_auditRecordId = $record_id;
    }
  }

  /**
    * adds a new field and value. Value is needed only for insert/update operations
    * @param string $fld field name in DB
    * @param string $val value (value gets quoted)
    * @param string $type type of $val, for using qstr, qint, qdec. One of: str, int, dec
    * @return void
    */
  function addField($fld, $val = '', $type = 'str') {
    if ($type == 'str')
      $s = $this->qstr($val);
    else
    if ($type == 'int')
      $s = $this->qint($val);
    else
    if ($type == 'dec')
      $s = $this->qdec($val);
    $this->_fldval[$fld] = $s;
  }

  /**
    * add condition statement (multiple calls are valid)
    * @param string $sql sql to concatenate to current condition string
    * @param string $operator "and" by default
    * @return void
    */
  function addCondition($sql, $operator = 'and') {
    if ($sql == '') return;
    if ($this->_condition == '')
      $this->_condition .= ' ' . $sql;
    else
      $this->_condition .= ' ' . $operator . ' ' . $sql;
  }

  /**
    * add order statement (multiple calls are valid)
    * @param string $sql sql to concatenate to current order string
    * @return void
    */
  function addOrder($sql) {
    if ($this->_order == '')
      $this->_order .= ' ' . $sql;
    else
      $this->_order .= ', ' . $sql;
  }

  /**
    * Create audit entries for each action
    * @param int $inserted_id for inserts this is the new record's id
    * @return boolean
    */
  function _auditAction($inserted_id = '') {
    $user_id = $_SESSION['UserId']; // XXX: global out of nowhere

    if (!$this->_auditEnabled) return true;

    if ($this->_action == 'insert') {
      $this->_auditRecordId = $inserted_id;
    }

    $res = true;

    if ($this->_action != 'delete') {
      // for insert and update, iterate fields executing one statement per field
      foreach ($this->_fldval as $fld => $val) {
        // for update, check that field indeed changed
        if ($this->_action == 'update') {
          $old_record = $this->select('select ' . $fld . ' from ' . $this->_auditTableName . ' where id=' . $this->_auditRecordId);
          if (count($old_record) != 1) {
            $res = false;
            break;
          }
          // if value is the same, continue with next field
          if ($this->qstr($old_record[0][$fld]) == $val) // $val is already qstr'ed
            continue;
        }
        $sql = '';
        $sql .= 'insert into sys_audit(date_inserted, sys_users_id, table_name, record_pk_value, field_name, field_value) values (';
        $sql .= $this->qstr($this->_auditDateInserted) . ',';
        $sql .= $this->qstr($user_id) . ',';
        $sql .= $this->qstr($this->_auditTableName) . ',';
        $sql .= $this->qstr($this->_auditRecordId) . ',';
        $sql .= $this->qstr($fld) . ',';
        $sql .= $val . ')'; // $val is already qstr'ed
        $res = $res && $this->_query($sql);
        if (!$res) break;
      }
    } else {
      // for delete, just create a single record
      $sql = '';
      $sql .= 'insert into sys_audit(date_inserted, sys_users_id, table_name, record_pk_value, field_name, field_value) values (';
      $sql .= $this->qstr($this->_auditDateInserted) . ',';
      $sql .= $this->qstr($user_id) . ',';
      $sql .= $this->qstr($this->_auditTableName) . ',';
      $sql .= $this->qstr($this->_auditRecordId) . ',';
      $sql .= $this->qstr('Record deleted') . ',';
      $sql .= $this->qstr('Record deleted') . ')';
      $res = $this->_query($sql);
    }

    return $res;
  }

  /**
    * executes action
    * @param integer $num_rows if given and the current action is a select, selectLimit will be used
    * @param integer $offset if given and the current action is a select, selectLimit will be used
    * @param string $type for select action, 'num' for numeric indices only, 'assoc' for associative indices only, 'both' for both
    * @return mixed on error returns false, on success: true for update/delete, array with results for select, inserted id for insert
    * (or 0 if it was not possible to get the last inserted id - but the insert was done)
    */
  function execute($num_rows = -1, $offset = -1, $type = 'both') {
    if ($this->_action == '') return false;

    if ($this->_action == 'select') {
      $sql = 'select ';
      if (count($this->_fldval) > 0) {
        foreach ($this->_fldval as $fld => $val)
          $sql .= $fld . ', ';
        $sql = sdf_substr($sql, 0, sdf_strlen($sql) - 2);
      } else
        $sql .= '*';
      $sql .= ' from ' . $this->_table;
      if ($this->_condition != '')
        $sql .= ' where ' . $this->_condition;
      if ($this->_order != '')
        $sql .= ' order by ' . $this->_order;
      if (($num_rows != -1) || ($offset != -1))
        return $this->selectLimit($sql, $num_rows, $offset, $type);
      else
        return $this->select($sql, $type);
    }

    // insert, update, delete start a transaction to make sure audit records get written
    // (only if a transaction is not already active)
    $must_start_transaction = (!$this->inTrans());

    if ($this->_action == 'insert') {
      if ($must_start_transaction)
        $this->beginTrans();
      $res = true;

      $sql = 'insert into ' . $this->_table . '(';
      foreach ($this->_fldval as $fld => $val)
        $sql .= $fld . ', ';
      $sql = sdf_substr($sql, 0, sdf_strlen($sql) - 2);
      $sql .= ') values (';
      foreach ($this->_fldval as $fld => $val)
        $sql .= $val . ', ';
      $sql = sdf_substr($sql, 0, sdf_strlen($sql) - 2);
      $sql .= ')';
      $res = $res && $this->_query($sql);

      // get inserted id
      if ($res) {
		switch ($this->_DBType) {
		    case 'postgres':
		        // PostgreSQL returns OID (if tables created with OID) and not last inserted id 
		        //   solution: http://archives.postgresql.org/pgsql-php/2003-09/msg00001.php
		        //   XXX the following solution works if table sequence is like: table_name_field_name_seq (e.g. customers_id_seq)
		        //   ideally the sequence name must be returned for given table, or pass as parameter    	
	      		$pg_sql='select currval(' . "'" . $this->_table . '_id_seq' . "'" . ')';
	          	$pg_res = $this->select($pg_sql, $type);
	          	$id=$pg_res[0][0];
		    	break;
		    case 'sqlite3':
	          	$sqlite3_res = $this->select('SELECT last_insert_rowid();');
	          	$id=$sqlite3_res[0][0];
		        break;
			default:
				 // uses ADODB's function Insert_ID(). Works for MySQL, SQL Server
				$id = $this->_dbiLink->Insert_ID();
		        break;
		}	
        if (($id == false) || ($id <= 0)) {
          if ($this->_auditEnabled)
            $res = false;
          else
            $id = 0; // if I am not auditing, then I accept inserts that return no IDs (otherwise session management won't work)
        }
      }
      if ($res)
        $res = $res && $this->_auditAction($id);

      if ($res) {
        if ($must_start_transaction)
          $this->commitTrans();
        return $id;
      } else {
        if ($must_start_transaction)
          $this->rollbackTrans();
        return false;
      }
    }

    if ($this->_action == 'update') {
      if ($must_start_transaction)
        $this->beginTrans();
      $res = true;

      $sql = 'update ' . $this->_table . ' set ';
      foreach ($this->_fldval as $fld => $val)
        $sql .= $fld . '=' . $val . ', ';
      $sql = sdf_substr($sql, 0, sdf_strlen($sql) - 2);
      if ($this->_condition != '')
        $sql .= ' where ' . $this->_condition;
      // For update, I must first audit and then do the real update. This way audit knows the changed fields.
      $res = $res && $this->_auditAction();
      if ($res)
        $res = $res && $this->_query($sql);

      if ($res) {
        if ($must_start_transaction)
          $this->commitTrans();
        return true;
      } else {
        if ($must_start_transaction)
          $this->rollbackTrans();
        return false;
      }
    }

    if ($this->_action == 'delete') {
      if ($must_start_transaction)
        $this->beginTrans();
      $res = true;

      $sql = 'delete from ' . $this->_table;
      if ($this->_condition != '')
        $sql .= ' where ' . $this->_condition;
      $res = $res && $this->_query($sql);
      if ($res)
        $res = $res && $this->_auditAction();

      if ($res) {
        if ($must_start_transaction)
          $this->commitTrans();
        return true;
      } else {
        if ($must_start_transaction)
          $this->rollbackTrans();
        return false;
      }
    }

  }

  /**
    * make a query to the DB and return the identifier
    * @param string $sql query to execute
    * @return mixed result identifier or false on failure
    */
  function _query($sql) {
    $result = $this->_dbiLink->Execute($sql);
    $this->lastError = $this->_dbiLink->ErrorMsg();
    $this->lastSQL = $sql;
    $this->queriesNumber++;
    $this->_logQuery();
    return $result;
  }

  /**
    * Gets an ASSOC array with one row of data (you can do both $result['ID'] and $result[0])
    * @param integer $result result identifier
    * @param string $type 'num' for numeric indices only, 'assoc' for associative indices only, 'both' for both
    * @return mixed array with result or false if no more rows exist
    */
  function _fetchArray(&$result, $type) {
    if (!is_object($result))
      return false;

    if ($result->EOF)
      return false;
    else {
      $max = $result->FieldCount();
  	  for ($i = 0; $i < $max; $i++) {
  	    $fld = $result->FetchField($i);
  	    $fn = $fld->name;
  	    $fv = $result->fields[$i];
  	    if (($type == 'both') || ($type == 'num'))
  	      $ar[$i] = $fv;
  	    if (($type == 'both') || ($type == 'assoc'))
  	      $ar[$fn] = $fv;
      }
      $result->MoveNext();
      return $ar;
    }
  }

  /**
    * free a recordset
    * @param integer $result result identifier
    * @return boolean
    */
  function _freeResult(&$result) {
    if (!is_object($result))
      return false;

    $result->Close();
  }

  /**
    * returns the number of rows in a recordset
    * @param integer $result result identifier
    * @return integer number of rows
    */
  function _numRows(&$result) {
    if (!is_object($result))
      return -1;

    return $result->RecordCount();
  }

  /**
    * moves the internal row pointer of a recordset to $row position
    * @param integer $result result identifier
    * @param integer $row where to place internal row pointer (zero based)
    * @return boolean
    */
  function _dataSeek(&$result, $row) {
    if (!is_object($result))
      return false;

    $result->Move($row);
  }

}
?>
