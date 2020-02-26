<?php
declare(strict_types=1);
namespace PangzLab\Lib\Data;

interface DataRepositorySettingInterface
{
    public function activateSetting(string $settingName): void;
    public function getDefinition(): array;
    public function getDataRepositorySource(): string;
}