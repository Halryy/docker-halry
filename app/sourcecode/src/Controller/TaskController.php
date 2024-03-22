<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class TaskController extends AbstractController
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    #[Route('/', 'homepage')]
    public function index(): Response
    {
        return $this->render('task/index.html.twig', []);
    }
    
    #[Route('/create', 'create-task', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $requestContent = $request->request->all();
        
        $task = new Task();

        $task->setContent($requestContent['taskContent']);
        $task->setStatus($requestContent['taskStatus']);

        $this->taskRepository->save($task);
        
        return $this->json(
            "ok ".$task->getId()
        );
    }
}