<?php
declare(strict_types=1);
namespace PangzLab\App\Routing;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PangzLab\Lib\Routing\Route;

use PangzLab\App\Service\DatabaseTransaction\DatabaseTransactionService;
use PangzLab\App\Service\UserRegistration\PoolRegistrationService;
use PangzLab\App\Model\User\JoiningUser;
use PangzLab\App\Config\Status;

class Pool extends Route
{
    private $dbTxService;
    CONST OPERATION = [
        "COMPLETED" => [
            "CODE" => 201,
            "MESSAGE" => "OPERATION COMPLETED"
        ],
        "NOT_ALLOWED" => [
            "CODE" => 202,
            "MESSAGE" => "OPERATION NOT ALLOWED"
        ],
    ];
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->dbTxService = new DatabaseTransactionService(
            $this->container->get('DatabaseService')
        );
    }

    public function addNewUser(Request $request, Response $response): Response
    {
        $service = new PoolRegistrationService($this->dbTxService);
        $status  = self::OPERATION["NOT_ALLOWED"];
        $message = "";
        $userId  = 0;

        $joiningUser = new JoiningUser([
            "publicAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk4h5jkfasdfd234jk",
            "walletAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk",
            "emailAddress"  => "jerold@gmail.com",
            "secretWords"   => ["test1", "test2", "test3"],
            "status"        => Status::USER_REGISTRATION["FOR_CONFIRMATION"]
        ]);
        
        if($service->isAllowed($joiningUser)) {
            $userId = $service->register($joiningUser);
            if($userId > 0) {
                $status = self::OPERATION["COMPLETED"];
            }
        }

        $payload = [
            "status" => [
                "code" => $status["CODE"],
                "message" => $status["MESSAGE"],
            ],
            "data" => [
                "id" => $userId,
                "body" => json_decode(file_get_contents('php://input'), true)
            ]
        ];

        $response->getBody()->write(json_encode($payload));
        return $response
          ->withHeader('Content-Type', 'application/json')
          ->withStatus($status["CODE"]);
    }
}