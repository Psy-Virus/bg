<?php
/*
 * @package AJAX_Chat
 * @author Sebastian Tschan
 * @copyright (c) Sebastian Tschan
 * @license GNU Affero General Public License
 * @link https://blueimp.net/ajax/
 */

// Class to initialize the DataBase connection:
class AJAXChatDataBase
{

    public $_db;

    public function AJAXChatDataBase(&$dbConnectionConfig)
    {
        switch ($dbConnectionConfig['type']) {
            case 'mysqli':
                $this->_db = new AJAXChatDatabaseMySQLi($dbConnectionConfig);
                break;
            case 'mysql':
                $this->_db = new AJAXChatDatabaseMySQL($dbConnectionConfig);
                break;
            default:
                // Use MySQLi if available, else MySQL (and check the type of a given database connection object):
                if (function_exists('mysqli_connect') && (!$dbConnectionConfig['link'] || is_object($dbConnectionConfig['link']))) {
                    $this->_db = new AJAXChatDatabaseMySQLi($dbConnectionConfig);
                } else {
                    $this->_db = new AJAXChatDatabaseMySQL($dbConnectionConfig);
                }
        }
    }
    
    // Method to connect to the DataBase server:
    public function connect(&$dbConnectionConfig)
    {
        return $this->_db->connect($dbConnectionConfig);
    }
    
    // Method to select the DataBase:
    public function select($dbName)
    {
        return $this->_db->select($dbName);
    }
    
    // Method to determine if an error has occured:
    public function error()
    {
        return $this->_db->error();
    }
    
    // Method to return the error report:
    public function getError()
    {
        return $this->_db->getError();
    }
    
    // Method to return the connection identifier:
    public function &getConnectionID()
    {
        return $this->_db->getConnectionID();
    }
    
    // Method to prevent SQL injections:
    public function makeSafe($value)
    {
        return $this->_db->makeSafe($value);
    }

    // Method to perform SQL queries:
    public function sqlQuery($sql)
    {
        return $this->_db->sqlQuery($sql);
    }
    
    // Method to retrieve the current DataBase name:
    public function getName()
    {
        return $this->_db->getName();
        //If your database has hyphens ( - ) in it, try using this instead:
        //return '`'.$this->_db->getName().'`';
    }

    // Method to retrieve the last inserted ID:
    public function getLastInsertedID()
    {
        return $this->_db->getLastInsertedID();
    }
}
?>
