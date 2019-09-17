<?php

class wuuDB{
    private static $database;
    public  static $pdo;
    public  static $result;
    /**
     * Create database connection if not exist
     *
     * @param string $host
     * @param string $user
     * @param string $pass
     * @return object
     */
    public function mysql($host="localhost", $user="root", $pass="", $reconnect=false){
        if(!self::$pdo || $reconnect) self::$pdo = new PDO("mysql:$host;charset=utf8", $user, $pass, [
            PDO::MYSQL_ATTR_FOUND_ROWS => true,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        else return self::$pdo;
    }
    public function query($query){
        // echo "<hr>QUERY:: <b>".$query."</b>";
        $query          = self::$pdo->prepare($query);
        self::$result   = $query->execute();
        // var_dump($query->errorInfo());
        // echo "<hr>";
        return $query;
    }
    /**
     * Set database to use
     *
     * @param string $db
     * @return bool
     */
    public function setDatabase($db){
        self::$database = $db;
        $pdo =  self::$pdo;
        $pdo->query("CREATE DATABASE IF NOT EXISTS `{$db}`");
        return $pdo->query("use `{$db}`");
    }
    public function dropDatabase($db){
        self::$database = $db;
        $pdo =  self::$pdo;
        return $pdo->query("DROP DATABASE `{$db}`");
    }
    public function getDatabase()   { return self::$database;   }
    public function setTable($table, $schema){
        $query = "CREATE TABLE IF NOT EXISTS `{$table}` (\n";
        $query .= "`_id` INT AUTO_INCREMENT NOT NULL,\n";
        $query .= "`_status` BOOLEAN NOT NULL DEFAULT '1',\n";
        foreach($schema as $name => $type) $query .= "`{$name}` {$type},\n";
        $query .= "PRIMARY KEY (`_id`)) CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;";
        // echo $query."<hr>";
        return self::$pdo->query($query);
    }
}