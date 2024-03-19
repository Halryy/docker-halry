<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController
{
    #[Route('/')]
    public function index(): Response
    {
        return new Response('hfdsfhs');
    }

    #[Route('/estudarSymfony')]
    public function estudarSymfony(): Response
    {
        return new Response('estudar symfony é muito bom');
    }
}