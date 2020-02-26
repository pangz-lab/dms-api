<?php
declare(strict_types=1);
namespace PangzLab\Lib\Data;

class DataException extends Exception {}
class DataSourceUnknownException extends DataException {}
class DataRepositorySettingUnknownException extends DataException {}