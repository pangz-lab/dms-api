<?php
declare(strict_types=1);
namespace PangzLab\App\Interfaces\Service;

use PangzLab\Lib\Data\StructuredDataInterface;

interface DatabaseInterface
{
    public function getInstance(string $dbName): StructuredDataInterface;
}