<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->render('task/index.html.twig', [
            'tasks'=> $this->taskRepository->findAll(),
        ]);
    }
    
    #[Route('/create', 'create-task', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): RedirectResponse
    {
        $requestContent = $request->request->all();
        
        $task = new Task();

        $task->setContent($requestContent['taskContent']);
        // $task->setStatus($requestContent['taskStatus']);

        $this->taskRepository->save($task);
        
        return $this->redirectToRoute('homepage');
    }

    #[Route('/update/{id}', 'update-task')]
    public function update(EntityManagerInterface $em): RedirectResponse
    {
        dd('fazer update');
    }

    #[Route('/delete/{id}', 'delete-task')]
    public function delete(EntityManagerInterface $em): RedirectResponse
    {
        dd('fazer delete');
    }
}