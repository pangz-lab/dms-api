<?php
declare(strict_types=1);
namespace PangzLab\App\Service;

use PangzLab\Lib\Data\StructuredDataInterface;
use PangzLab\Lib\Exception\ServiceException;

class MySqlDbService implements StructuredDataInterface
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $dsn;
    private $instance;

    const QUERY_FORMAT = [
        "select" => [
            "template" => "SELECT %s FROM %s %s %s %s",
            "parameter" => [
                "_columns" => [],
                "_table" => "",
                "_condition" => "",
                "_groupBy" => "",
                "_orderBy" => ""
            ]
        ],
        "insert" => [
            "template" => "INSERT INTO %s (%s) VALUES %s %s",
            "parameter" => [
                "_table" => "",
                "_columns" => [],
                "_columnValues" => [],
                "_condition" => ""
            ]
        ],
        "delete" => [
            "template" => "DELETE FROM %s WHERE %s",
            "parameter" => [
                "_table" => "",
                "_condition" => ""
            ]
        ],
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

    /**
     * @param array $params Format should be as self::QUERY_FORMAT["insert"]["parameter"]
     */
    public function createData(
        array $params,
        ?array $bindingParam = null
    ) {
        $op       = "insert";
        $insertId = 0;
        $binding  = $bindingParam ?? [];
        $params   = (object) array_merge($this->_getQuery("parameter", $op), $params);
        $sql      = sprintf(
            $this->_getQuery("template", $op),
            $params->_table,
            $this->_formatColumn($params->_columns, $op),
            $this->_createRowObject($params->_columnValues),
            (!empty($params->_condition))? "WHERE ".$params->_condition: ""
        );

        $stmt = $this->instance->prepare($sql);
        try {
            $this->instance->beginTransaction();
            $stmt->execute($binding);
            $insertId = (int) $this->instance->lastInsertId();
            $this->instance->commit();

        } catch(\PDOExecption $e) {
            throw new ServiceException(
                "Insertion failed to Mysql DB! [".$e->getMessage()."]"
            );
        }

        return $insertId;
    }

    /**
     * @param array $params Format should be as self::QUERY_FORMAT["select"]["parameter"]
     * @param string $rowModelClass the class to be used as a row model for generating
     * the resultset. This will be the object of each row.
     */
    public function getData(
        array $params,
        ?array $bindingParam  = null,
        ?string $rowModelClass = null
    ) {
        $op      = "select";
        $binding = $bindingParam ?? [];
        $params  = (object) array_merge($this->_getQuery("parameter", $op), $params);
        $fetch   = (!is_null($rowModelClass))? [ 
            \PDO::FETCH_CLASS,
            $rowModelClass
        ] : [];

        $sql = sprintf(
            $this->_getQuery("template", $op),
            $this->_formatColumn($params->_columns, $op),
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

    public function deleteData(
        array $params,
        ?array $bindingParam = null
    ) {
        $op       = "delete";
        $binding  = $bindingParam ?? [];
        $params   = (object) array_merge($this->_getQuery("parameter", $op), $params);
        $sql      = sprintf(
            $this->_getQuery("template", $op),
            $params->_table,
            $params->_condition
        );

        $stmt = $this->instance->prepare($sql);
        try {
            $this->instance->beginTransaction();
            $stmt->execute($binding);
            $this->instance->commit();

        } catch(\PDOExecption $e) {
            throw new ServiceException(
                "Insertion failed to Mysql DB! [".$e->getMessage()."]"
            );
        }

        return true;
    }

    public function establishConnection(array $options = [\PDO::ATTR_PERSISTENT => true])
    {
        try{
            $this->instance = new \PDO(
                $this->dsn,
                $this->username,
                $this->password,
                $options
            );

            return $this;

        } catch (\PDOException $e) {
            throw new ServiceException(
                "Cannot connect to Mysql DB! [".$e->getMessage()."]"
            );
        }
    }

    private function _formatColumn(array $columns, string $operation): string
    {
        switch($operation) {
            case "select":
                if(count($columns) > 0) {
                    return implode(",", $columns);
                } else {
                    return "*";
                }

            case "insert":
                $list = array_map(
                    function($item) {
                        return "`$item`";
                    },
                    $columns
                );

                return implode(",", $list);
        }
    }

    private function _createRowObject(array $params): string
    {
        $rowFormat = "(%s)";
        $list      = [];
        foreach($params as $currentValue) {
            $list[] = sprintf($rowFormat, implode(" , " ,$currentValue));
        }

        return implode(",", $list);
    }

    private function _getQuery(string $key, string $operation)
    {
        return self::QUERY_FORMAT[$operation][$key];
    }
}