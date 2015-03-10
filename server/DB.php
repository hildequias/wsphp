<?php

/**
 * Class connection with the MySQL database,
 * PHP/PDO.
 * You must have defined the following constants: DB_NAME, DB_HOST, DB_USER, DB_PASSWORD
 */
class DB {

    /**
     * Instance singleton
     * @var DB 
     */
    private static $instance;
    
    /**
     * Connecting to the database
     * @var PDO 
     */
    private static $connection;

    /**
     * Private constructor singleton class
     * 
     */ 
    private function __construct() {
        self::$connection = new PDO("mysql:dbname=" . DB_NAME . ";host=" . DB_HOST, DB_USER, DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    /**
     * Get the instance DB class
     * @return type
     */
    public static function getInstance() {

        if (empty(self::$instance)) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    /**
     * Returns the PDO connection to the database
     * @return PDO
     */
    public static function getConn() {
        self::getInstance();
        return self::$connection;
    }

    /**
     * Prepare the sql to run later
     * @param String $sql
     * @return PDOStatement stmt
     */
    public static function prepare($sql) {
        return self::getConn()->prepare($sql);
    }

    /**
     * Returns the id of the last INSERT query
     * @return int
     */
    public static function lastInsertId() {
        return self::getConn()->lastInsertId();
    }
    
    /**
     * Begin a transaction
     * @return bool
     */
    public static function beginTransaction(){
        return self::getConn()->beginTransaction();
    }
    
    /**
     * Commit a transaction
     * @return bool
     */
    public static function commit(){
        return self::getConn()->commit();
    }
    
    /**
     * Performs a rollback in the transaction
     * @return bool
     */
    public static function rollBack(){
        return self::getConn()->rollBack();
    }

    /**
     * Format a date for MySql (05/12/2012 to 2012-12-05)
     * @param type $date
     * @return type
     */
    public static function dateToMySql($date)
    {
        return implode("-",array_reverse(explode("-",$date))); 
    }
    
    /**
     * Format a date from MySql (2012-12-05 to 05/12/2012)
     * @param type $date
     * @return type
     */
    public static function dateFromMySql($date)
    {
         return implode("/",array_reverse(explode("-",$date)));
    }
    
    public static function decimalToMySql($value)
    {
        $value = str_replace(".","",$value);
        $value = str_replace(",",".",$value);
        return $value;
    }

}