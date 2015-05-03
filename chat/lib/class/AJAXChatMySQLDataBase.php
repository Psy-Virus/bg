<?php
/*
 * @package AJAX_Chat
 * @author Sebastian Tschan
 * @copyright (c) Sebastian Tschan
 * @license GNU Affero General Public License
 * @link https://blueimp.net/ajax/
 */

// Class to initialize the MySQL DataBase connection:
class AJAXChatDataBaseMySQL
{

    public $_connectionID;
    public $_errno = 0;
    public $_error = '';
    public $_dbName;

    public function AJAXChatDataBaseMySQL(&$dbConnectionConfig)
    {
        $this->_connectionID = $dbConnectionConfig['link'];
        $this->_dbName = $dbConnectionConfig['name'];
    }
    
    // Method to connect to the DataBase server:
    public function connect(&$dbConnectionConfig)
    {
        $this->_connectionID = @mysql_connect(
            $dbConnectionConfig['host'],
            $dbConnectionConfig['user'],
            $dbConnectionConfig['pass'],
            true
        );
        if (!$this->_connectionID) {
            $this->_errno = null;
            $this->_error = 'Database connection failed.';
            return false;
        }
        return true;
    }
    
    // Method to select the DataBase:
    public function select($dbName)
    {
        if (!@mysql_select_db($dbName, $this->_connectionID)) {
            $this->_errno = mysql_errno($this->_connectionID);
            $this->_error = mysql_error($this->_connectionID);
            return false;
        }
        $this->_dbName = $dbName;
        return true;
    }
    
    // Method to determine if an error has occured:
    public function error()
    {
        return (bool)$this->_error;
    }
    
    // Method to return the error report:
    public function getError()
    {
        if ($this->error()) {
            $str = 'Error-Report: '    .$this->_error."\n";
            $str .= 'Error-Code: '.$this->_errno."\n";
        } else {
            $str = 'No errors.'."\n";
        }
        return $str;
    }
    
    // Method to return the connection identifier:
    public function &getConnectionID()
    {
        return $this->_connectionID;
    }
    
    // Method to prevent SQL injections:
    public function makeSafe($value)
    {
        return "'".mysql_real_escape_string($value, $this->_connectionID)."'";
    }
    
    // Method to perform SQL queries:
    public function sqlQuery($sql)
    {
        return new AJAXChatMySQLQuery($sql, $this->_connectionID);
    }

    // Method to retrieve the current DataBase name:
    public function getName()
    {
        return $this->_dbName;
    }

    // Method to retrieve the last inserted ID:
    public function getLastInsertedID()
    {
        return mysql_insert_id($this->_connectionID);
    }
}
?>
