<?php
declare(strict_types=1);
namespace PangzLab\App\Middleware\ErrorHandlerRenderer;

//use PangzLab\Lib\Middleware\MiddlewareInterface;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Interfaces\ErrorRendererInterface;
use Throwable;

class ErrorRequestRenderer implements ErrorRendererInterface
{
    public function __invoke(Throwable $exception, bool $displayErrorDetails): string
    {
        if ($exception instanceof HttpInternalServerErrorException) {
            $title = 'Page not found';
            $message = 'This page could not be found.';
        }
 
        // return $this->renderHtmlPage($title, $message);
        return $this->renderJsonResult();
    }

    public function renderJsonResult(): string
    {
        return \json_encode([
            "status" => [
                "code" => 500,
                "message" => "Internal Server Error! Service unavailable."
            ],
        ]);
    }

    public function renderHtmlPage(string $title = '', string $message = ''): string
    {
        $title = htmlentities($title, ENT_COMPAT|ENT_HTML5, 'utf-8');
        $message = htmlentities($message, ENT_COMPAT|ENT_HTML5, 'utf-8');
 
        return <<<EOT
<!DOCTYPE html>
<html>
<head>
  <title>$title - My website</title>
  <link rel="stylesheet"
     href="https://cdnjs.cloudflare.com/ajax/libs/mini.css/3.0.1/mini-default.css">
</head>
<body>
  <h1>$title</h1>
  <p>$message</p>
</body>
</html>
EOT;
    }
}