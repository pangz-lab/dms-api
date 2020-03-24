<?php
declare(strict_types=1);
namespace PangzLab\App\Service\DatabaseTransaction;

use PangzLab\Lib\Data\StructuredDataInterface;

class UpdateService
{
    private $dbInstance;

    public function __construct(StructuredDataInterface $db)
    {
        $this->dbInstance = $db;
    }
}