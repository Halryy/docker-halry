<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/')]
    public function index(): Response
    {
        $users = [
            ['name'=> 'fulano','phone'=> '(16) 9999-9999'],
            ['name'=> 'ciclano','phone'=> '(11) 4231-1234'],
            ['name'=> 'beltrano','phone'=> '(47) 4444-4444'],
            ['name'=> 'butano','phone'=> '(22) 4215-4552'],
            ['name'=> 'propano','phone'=> '(15) 94324-4264'],
        ];
        return $this->render('hello/homepage.html.twig', [
            'users' => $users
        ]);
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