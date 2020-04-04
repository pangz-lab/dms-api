<?php
declare(strict_types=1);
namespace PangzLab\App;

use PangzLab\Lib\Routing\RouteMethodCollectionInterface;
use PangzLab\Lib\Routing\RouteUnit;

class RouteSetting implements RouteMethodCollectionInterface
{
    const VERSION = "v1";
    public static function get(): array
    {
        $v = self::VERSION;
        return [
            // new RouteUnit('/books/{id}', ['User:getBooks'], 'books1'),
            // new RouteUnit('/books/{id}/reset', ['User:getBooks','User:getBooks', 'User:getBooks']),
            // new RouteUnit("/wallets", ['Wallet:getSummary']),
            new RouteUnit("/$v/transactionsTestGet", ['Transaction:testGetSummary']),
            
            new RouteUnit("/$v/transactions", ['Transaction:getSummary']),
            new RouteUnit("/$v/transactions/list", ['Transaction:getList']),
            new RouteUnit("/$v/histories/update-summary", ['History:getUpdateEventSummary']),
            new RouteUnit("/$v/balances/summary/stakevsrewards", ['Balance:getStakeVsRewards']),
        ];
    }

    public static function post(): array {

        $v = self::VERSION;
        return [
            new RouteUnit("/$v/pool/user/add", ['Pool:addNewUser']),
        ];
    }
    public static function put(): array {return [];}
    public static function delete(): array {return [];}
    public static function head(): array {return [];}
    public static function patch(): array {return [];}
    public static function options(): array {return [];}

    public static function any(): array
    {
        return [
            new RouteUnit('/', ['User:getList']),
            new RouteUnit('/books', ['User:getList']),
        ];
    }
}