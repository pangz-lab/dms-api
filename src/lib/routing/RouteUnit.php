<?php
declare(strict_types=1);
namespace PangzLab\Lib\Routing;

class RouteUnit implements RouteUnitInterface
{
    private $route;
    private $method;
    private $name;

    public function __construct(
        string $route,
        array $method,
        string $name = null
    ) {
        $this->route  = $route;
        $this->method = $method;
        $this->name   = $name ?? '';
    }
    
    public function getRoute(): string
    {
        return $this->route;
    }

    public function getMethod(): string
    {
        return $this->method[0];
    }

    public function getMethodList(): array
    {
        return $this->method;
    }

    public function getMethodCount(): int
    {
        return count($this->method);
    }

    public function getName(): string
    {
        return $this->name;
    }
}