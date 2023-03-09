<?php

namespace App\Controller;

use App\Entity\Task;
use App\Service\ConditionServices;
use App\Service\TaskServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;

class TaskController extends AbstractController
{
    #[Route('/task', name: 'app_task')]
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }

    #[Route('/task/add', name: 'app_task_add')]
    public function addTask(
        Request $request,
        TaskServices $taskServices,
    ): Response
    {
        // Убеждаемся, что пользователь авторизован, а не просто перешёл по ссылке
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $parameters = json_decode($request->getContent(), true);
        $newTask = $taskServices->createTask(
            $this->getUser()->getId(),
            $parameters["taskName"],
            $parameters["taskDescription"],
            $parameters["taskUrgency"],
            $parameters["taskDeadline"]
        );
        $taskServices->saveTask($newTask);
        return new JsonResponse(array('id' => $newTask->getId(), 'name' => $newTask->getName()));
    }

    #[Route('/task/delete', name: 'app_task')]
    public function deleteTask(
        Request $request,
        TaskServices $taskServices,
    )
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $parameters = json_decode($request->getContent(), true);
        $taskServices->deleteTaskById($parameters["taskId"]);
        return new Response('Task deleted');
    }

    #[Route('task/change-condition', name: 'app_task_change_condition')]
    public function changeTaskCondition(
        Request $request,
        TaskServices $taskServices,
        ConditionServices $conditionServices
    ) {
        $parameters = json_decode($request->getContent(), true);
        $task = $taskServices->getTaskById((int) $parameters["taskId"]);
        $conditionId = $conditionServices->getConditionByName($parameters["conditionName"])->getId();
        $task->setConditionId($conditionId);
        $taskServices->saveTask($task);
        return new Response('Changed task condition');
    }

}
