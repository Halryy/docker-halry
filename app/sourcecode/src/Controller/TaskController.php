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
            'tasks' => $this->taskRepository->findAll(),
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
    public function update($id, Request $request, EntityManagerInterface $em): Response
    {
        $method = $request->getMethod();

        if ($method == 'POST') {
            $requestContent = $request->request->all();

            $task = $em->getRepository(Task::class)->find($id);
            $task->setContent($requestContent['taskContent']);

            $this->taskRepository->save($task);
            
            return $this->redirectToRoute('homepage');
        }

        return $this->render('task/edit.html.twig', [
            'task' => $em->getRepository(Task::class)->find($id)
        ]);

    }

    #[Route('/delete/{id}', 'delete-task')]
    public function delete($id, EntityManagerInterface $em): RedirectResponse
    {
        $task = $em->getRepository(Task::class)->find($id);
        $this->taskRepository->delete($task);

        return $this->redirectToRoute('homepage');
    }
}