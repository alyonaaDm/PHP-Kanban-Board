<?php

namespace App\Service;

use App\Entity\Task;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class TaskServices extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    public function createTask(
        int $userId,
        string $taskName,
        string $taskDescription,
        string $taskUrgency,
        string $taskDeadline
    ): Task {
        $dateDeadline = new DateTime($taskDeadline);
        $newTask = new Task($userId, $taskName, $taskDescription, $taskUrgency, $dateDeadline);
        return $newTask;
    }

    public function saveTask(Task $task): void
    {
        $this->entityManager->getRepository(Task::class)->save($task, true);
    }

    public function getTasksByUserId(int $userId): array
    {
        $allTasks = $this->entityManager->getRepository(Task::class)->getAllTasksByUserId($userId);
        $tasks = [];
        foreach ($allTasks as $task) {
            $tasks[$task["conditionId"]][] = $task;
        }
        return $tasks;
    }

    public function deleteTaskById(int $id): void
    {
        $taskRepository = $this->entityManager->getRepository(Task::class);
        $task = $taskRepository->find($id);
        $taskRepository->remove($task, true);
    }

    public function getTaskById(int $id)
    {
        return $this->entityManager->getRepository(Task::class)->find($id);
    }

    public function getAllTasks()
    {
        $allTasks = $this->entityManager->getRepository(Task::class)->findAll();
        $tasks = [];
        foreach ($allTasks as $task) {
            $tasks[$task->getConditionId()][] = $task;
        }
        return $tasks;
    }
}