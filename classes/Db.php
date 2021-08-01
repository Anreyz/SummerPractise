<?php

class Db
{
    protected $dbh;

    public function __construct()
    {
        $config = require_once __DIR__ . '/../config.php';
        $dsn = $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['dbname'];
        try{
            $this->dbh = new \Pdo($dsn, $config['username'], $config['pass']);

            //$this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

          //  echo "Connect Successfully. Host info: " .
           // $this->dbh->getAttribute(constant("PDO::ATTR_CONNECTION_STATUS"));
            
        } catch(PDOException $e) {
            die ("ERROR: Could not connect. " . $e->getMessage());
        }
        
    }

    public function execute(string $sql)
    {
        $sth = $this->dbh->prepare($sql);
        return $sth->execute();

    }

    public function query(string $sql, array $data=[])
    {
        $sth = $this->dbh->prepare($sql);
       // echo '<br><br><br>';
       // var_dump($sth);
        //echo '<br><br><br>';
        $sth->execute($data);
        //var_dump($data);
       // echo '<br><br><br>';
        //var_dump($sth->fetchAll(\PDO::FETCH_OBJ));
        return $sth->fetchAll(\PDO::FETCH_OBJ); 
    }
}