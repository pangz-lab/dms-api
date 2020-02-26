<?php
declare(strict_types=1);
namespace PangzLab\App\Service;
use PangzLab\Lib\Data\StructuredDataInterface;
use PangzLab\Lib\Data\DatabaseParameter as DbParam;

class MySqlDbService implements StructuredDataInterface
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $dsn;
    private $instance;

    const SELECT_TEMPLATE = "SELECT %s FROM %s %s %s %s";
    public static $parameterFormat = ["","","","","",
        "_columns" => "*",
        "_table" => "",
        "_condition" => "",
        "_groupBy" => "",
        "_orderBy" => ""
    ];

    public function __construct(DbParam $param)
    {
        $this->host     = $param->host;
        $this->username = $param->username;
        $this->password = $param->password;
        $this->database = $param->database;
        $this->dsn      = "mysql:dbname=".$this->database.";host=".$this->host;
    }

    public function getDataType()
    {

    }

    public function getSize()
    {

    }

    public function createData(DbParam $param)
    {

    }

    public function getData(DbParam $p)
    {
        //@TODO should have a binding instead of simple substitution
        $binding = [];
        $sql = sprintf(
            static::SELECT_TEMPLATE,
            $p->_columns,
            $p->_table,
            (!empty($p->_condition))? "WHERE ".$p->_condition: "",
            (!empty($p->_groupBy))? "GROUP BY ".implode(", ", $p->_groupBy): "",
            (!empty($p->_orderBy))? "ORDER BY ".implode(", ", $p->_orderBy): ""
        );

        $stmt = $this->instance->prepare($sql);
        if($stmt->execute($binding)) {            
            return $stmt->fetchAll();
        }
        return [];
    }

    public function updateData(DbParam $param)
    {

    }

    public function deleteData(DbParam $param)
    {

    }

    public function establishConnection()
    {
        $this->instance = new \PDO(
            $this->dsn,
            $this->username,
            $this->password
        );
        return $this;
    }
}