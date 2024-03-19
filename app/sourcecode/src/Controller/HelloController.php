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

    // {nome_do_animal} || {slug}
    #[Route('/animal/{nome_do_animal}')]
    public function animal(string $nome_do_animal = null): Response
    {
        return new Response('olá, '.$nome_do_animal);
    }

    #[Route('/estudar_symfony')]
    public function estudarSymfony(): Response
    {
        return new Response('estudar symfony é muito bom');
    }
}