<?php
declare(strict_types=1);
namespace PangzLab\Lib\Routing;

interface RouteUnitInterface
{
    public function getRoute(): string;
    public function getName(): string;
    public function getMethod(): string;
}