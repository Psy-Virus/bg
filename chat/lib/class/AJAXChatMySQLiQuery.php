<?php
/*
 * @package AJAX_Chat
 * @author Sebastian Tschan
 * @copyright (c) Sebastian Tschan
 * @license GNU Affero General Public License
 * @link https://blueimp.net/ajax/
 */

// Class to perform SQL (MySQLi) queries:
class AJAXChatMySQLiQuery
{

    public $_connectionID;
    public $_sql = '';
    public $_result = 0;
    public $_errno = 0;
    public $_error = '';

    // Constructor:
    public function AJAXChatMySQLiQuery($sql, $connectionID)
    {
        $this->_sql = trim($sql);
        $this->_connectionID = $connectionID;
        $this->_result = $this->_connectionID->query($this->_sql);
        if (!$this->_result) {
            $this->_errno = $this->_connectionID->errno;
            $this->_error = $this->_connectionID->error;
        }
    }

    // Returns true if an error occured:
    public function error()
    {
        // Returns true if the Result-ID is valid:
        return !(bool)($this->_result);
    }

    // Returns an Error-String:
    public function getError()
    {
        if ($this->error()) {
            $str  = 'Query: '     .$this->_sql  ."\n";
            $str .= 'Error-Report: '    .$this->_error."\n";
            $str .= 'Error-Code: '.$this->_errno;
        } else {
            $str = "No errors.";
        }
        return $str;
    }

    // Returns the content:
    public function fetch()
    {
        if ($this->error()) {
            return null;
        } else {
            return $this->_result->fetch_assoc();
        }
    }

    // Returns the number of rows (SELECT or SHOW):
    public function numRows()
    {
        if ($this->error()) {
            return null;
        } else {
            return $this->_result->num_rows;
        }
    }

    // Returns the number of affected rows (INSERT, UPDATE, REPLACE or DELETE):
    public function affectedRows()
    {
        if ($this->error()) {
            return null;
        } else {
            return $this->_connectionID->affected_rows;
        }
    }

    // Frees the memory:
    public function free()
    {
        $this->_result->free();
    }
}
?>
