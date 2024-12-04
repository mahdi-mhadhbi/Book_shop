<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ErrorHandelController extends AbstractController
{
    public function handleException(\Throwable $exception): Response
    {
        $statusCode = $exception instanceof HttpExceptionInterface
            ? $exception->getStatusCode()
            : Response::HTTP_INTERNAL_SERVER_ERROR;

        $template = [
            404 => 'error_handel/index404.html.twig',
            403 => 'error_handel/index.html.twig',
            500 => 'error_handel/index500.html.twig',
            503 => 'error_handel/index503.html.twig'
        ];

        $template = $templates[$statusCode] ?? 'error_handel/index.html.twig';

        return $this->render($template, [
            'status_code' => $statusCode,
            'message' => $exception->getMessage(),
        ]);
    }
}
