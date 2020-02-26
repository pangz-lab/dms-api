<?php
declare(strict_types=1);
namespace PangzLab\App\Routing;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

use PangzLab\Lib\Routing\Route;
use PangzLab\App\Repository\User as UserRepository;

class User extends Route
{
    private $repo;
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->repo = new UserRepository($this->container);
    }

    public function getBooks(Request $request, Response $response, $args)
    {
        $response->getBody()->write("Hello world!".$args['id']);
        return $response;
    }

    public function getBooks2(Request $request, Response $response, $args)
    {
        $response->getBody()->write("Hello world2B >>>!".$args['id']);
        return $response;
    }

    public function getList(Request $request, Response $response, $args)
    {
        $pv = $request->getAttribute('testPass') ?? null;
        if($pv) {
            $request->wiAttribute('testPass') ?? null;
        }        
        $hs = "";

        if($this->container->has('PostService')) {
            $hs = ' Has Post service';
        } else {
            $hs = ' No Post service';
        }

        // $response->getBody()->write("Hello world2B: This is the list  [[ $hs ]] >> ".$this->container->get('DatabaseService')->getDBName());
        // $response->getBody()->write("Hello world2B: This is the list  [[ $hs ]] >> ".serialize($this->container->get('DatabaseService')->getRecords()));
        $response->getBody()->write("Hello world2B: This is the list  [[ $hs ]] >> ".$this->repo->toJson($this->repo->getDetail()));
        
        

        return $response;
    }
}