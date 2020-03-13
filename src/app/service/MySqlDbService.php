<?php
declare(strict_types=1);
namespace PangzLab\App\Service;

use PangzLab\Lib\Data\StructuredDataInterface;

class MySqlDbService implements StructuredDataInterface
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $dsn;
    private $instance;

    const SELECT_TEMPLATE = "SELECT %s FROM %s %s %s %s";
    public static $parameterFormat = [
        "_columns" => "*",
        "_table" => "",
        "_condition" => "",
        "_groupBy" => "",
        "_orderBy" => ""
    ];

    public function __construct(array $param)
    {
        $this->host     = $param['host'] ?? "";
        $this->username = $param['username'] ?? "";
        $this->password = $param['password'] ?? "";
        $this->database = $param['database'] ?? "";
        $this->dsn      = "mysql:dbname=".$this->database.";host=".$this->host;
    }

    public function getDataType()
    {

    }

    public function getSize()
    {

    }

    public function createData(array $param)
    {

    }

    public function getData(array $params, ?string $rowModelClass = null)
    {
        //@TODO should have a binding instead of simple substitution
        $binding  = [];
        $params   = (object) array_merge(MySqlDbService::$parameterFormat, $params);
        $fetch    = (!is_null($rowModelClass))? [ 
            \PDO::FETCH_CLASS,
            $rowModelClass
        ] : [];
        $sql      = sprintf(
            static::SELECT_TEMPLATE,
            $params->_columns,
            $params->_table,
            (!empty($params->_condition))? "WHERE ".$params->_condition: "",
            (!empty($params->_groupBy))? "GROUP BY ".implode(", ", $params->_groupBy): "",
            (!empty($params->_orderBy))? "ORDER BY ".implode(", ", $params->_orderBy): ""
        );

        $stmt = $this->instance->prepare($sql);

        if($stmt->execute($binding)) {
            return $stmt->fetchAll(...$fetch);
        }

        return [];
    }

    public function updateData(array $param)
    {

    }

    public function deleteData(array $param)
    {

    }

    public function establishConnection()
    {
        $this->instance = new \PDO(
            $this->dsn,
            $this->username,
            $this->password,
            [
                \PDO::ATTR_PERSISTENT => true
            ]
        );
        return $this;
    }
}