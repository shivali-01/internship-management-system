<?php

class Database
{
    private $host = 'devharbor.online';
    private $port = 3306;
    private $database = 'devhara1f3f9_dh_shivali01c35c41';
    private $username = 'devhara1f3f9_dh_shivali0b9079a';
    private $password = '6ebb4a86d4e4ff38a3a9136d';

    private $conn;
    private $stmt;

    public function __construct()
    {
        try {

            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->database};charset=utf8mb4";

            $options = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $this->conn = new PDO(
                $dsn,
                $this->username,
                $this->password,
                $options
            );

        } catch (PDOException $e) {

            die("Database Connection Failed: " . $e->getMessage());

        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function query($sql)
    {
        $this->stmt = $this->conn->prepare($sql);
        return $this;
    }

    public function bind($param, $value, $type = null)
    {
        if ($type === null) {

            switch (true) {

                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;

                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;

                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;

                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function resultSet()
    {
        $this->execute();

        return $this->stmt->fetchAll();
    }

    public function single()
    {
        $this->execute();

        return $this->stmt->fetch();
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }
}

$db = new Database();

?>
