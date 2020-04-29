<?php


namespace App\Tools;
use PDO;

class DatabaseTools
{
    private $host;
    private $dbName;
    private $user;
    private $password;
    private $dsn;
    private $pdo;


    public function __construct($host, $dbName, $user, $password)
    {
        $this->host = $host;
        $this->dbName = $dbName;
        $this->user = $user;
        $this->password = $password;

        $this->dsn = "mysql:host=$host;dbname=$dbName";
        $this->initDatabase();
    }
    public function initDatabase(){
            $this->pdo = new PDO($this->dsn, $this->user, $this->password);
    }
    public function executeQuery($SQL){
        $result = $this->pdo->query($SQL);
        return $result->fetchAll();
    }

    public function getAllFrom($table){
        $result = $this->pdo->query("SELECT * FROM $table");
        return $result->fetchAll();
    }
    /*
     * un param serait = ["paramKey" => ":name", "paramValue" => "Claude"]
     */

    public function sqlQuery($sql, $params) {
            foreach ($params as $param){
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($param);
            }
    }

    public function selectBy($select, $tableName){
        $result = $this->pdo->query("SELECT $select FROM $tableName ");
        return $result->fetch();
    }

}
