<?php
declare(strict_types=1);
namespace PangzLab\App\Service\DatabaseTransaction;

use PangzLab\Lib\Data\StructuredDataInterface;

class TransactionMap
{
    protected $dbInstance;
    protected $table;
    protected $columns;
    protected $values;
    protected $condition;
    protected $binding;

    public function __construct(StructuredDataInterface $db)
    {
        $this->dbInstance = $db;
    }

    public function inTable(string $table)
    {
        $this->table = $table;
        return $this;
    }

    public function withColumns(array $columns)
    {
        $this->columns = $columns;
        return $this;
    }

    public function forColumns(array $columns)
    {
        $this->columns = $columns;
        return $this;
    }

    public function withValues(array $values)
    {
        $this->values = $values;
        return $this;
    }

    public function where(string $condition)
    {
        $this->condition = $condition;
        return $this;
    }

    public function boundBy(array $binding)
    {
        $this->binding = $binding;
        return $this;
    }

    public function execute() {}
}