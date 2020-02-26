<?php
declare(strict_types=1);
namespace PangzLab\Lib\Data;

interface UnStructuredDataInterface extends DataStructureInterface
{
    public function getList();
    public function getFormat();
    public function getUri();
    public function getDefinition();
}