<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $em;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Task::class);
        $this->em = $em;
    }

    public function save(Task $task){
        $this->em->persist($task);
        $this->em->flush();
    }

    public function findAllTasks() {
        return $this->createQueryBuilder('p')
        ->getQuery()
        ->getResult();
    }
}
