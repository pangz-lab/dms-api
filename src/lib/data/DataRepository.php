<?php
declare(strict_types=1);
namespace PangzLab\Lib\Data;

class DataRepository
{
    private $dataSource;

    public function __construct(DataRepositorySettingInterface $setting)
    {
        $className        = $setting->getDataRepositorySource();
        $this->dataSource = new $className($setting->getDefinition());
        if(!($this->dataSource instanceof StructuredDataInterface || $this->dataSource instanceof UnStructuredDataInterface)) {
            throw new DataSourceUnknownException();
        }

        if($this->dataSource instanceof StructuredDataInterface) {
            $this->dataSource->establishConnection();
        }

        return $this->dataSource;
    }
}
