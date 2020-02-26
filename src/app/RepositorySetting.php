<?php
declare(strict_types=1);
namespace PangzLab\App;

use PangzLab\Lib\Data\DataRepositorySettingInterface;

class RepositorySetting implements DataRepositorySettingInterface
{
    private $activeSetting;
    private $setting = [
        "mysqldb" => [
            "dataRepositorySource" => "MySqlDbRepository",
            "definition" => [
                "host"      => "localhost",
                "username"  => "root",
                "password"  => "",
            ]
        ],
    ];
    
    public function activateSetting(string $settingName): void
    {
        if(!$this->checkSettingFormatIsValid($settingName)) {
            throw new DataRepositorySettingFormatError();
        }
        $this->activeSetting = $this->setting[$settingName];
    }

    public function getDefinition(): array
    {
        return $this->activeSetting["definition"];
    }

    public function getDataRepositorySource(): string
    {
        return $this->activeSetting["dataRepositorySource"];
    }

    private function checkSettingFormatIsValid(string $settingName): bool
    {
        return (
            !isset($this->setting[$settingName]) ||
            !isset($this->setting[$settingName]["definition"]) ||
            !isset($this->setting[$settingName]["dataRepositorySource"])
        );
    }
}