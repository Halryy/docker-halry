<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoListController extends AbstractController
{
    #[Route('/', 'homepage')]
    public function index(): Response
    {
        return $this->render('todolist/index.html.twig', []);
    }

    #[Route('/create', 'create-task', methods: ['POST'])]
    public function create()
    {
        dd('fazer criação de tarefas');
    }
}