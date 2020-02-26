<?php
declare(strict_types=1);
namespace PangzLab\Lib\Repository;

use DI\Container;
use Slim\App;

class Repository
{
    protected $container;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function toJson($data)
    {
        return \json_encode($data);
    }
}