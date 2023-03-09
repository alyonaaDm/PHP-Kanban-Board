<?php

namespace App\Controller;

use App\Entity\Condition;
use App\Service\BoardServices;
use App\Service\TaskServices;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;

class BoardController extends AbstractController
{
    #[Route('/board', name: 'app_board')]
    public function index(BoardServices $boardServices, TaskServices $taskServices): Response
    {
        $allConditions = $boardServices->getAllConditions();
        $tasks = $taskServices->getAllTasks();
        return $this->render('board/index.html.twig', [
            'conditions' => $allConditions,
            'tasks' => $tasks,
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/board/edit')]
    public function addConditionPage(BoardServices $boardServices)
    {
        $boardTypes = $boardServices->getAllConditions();
        return $this->render('board/edit.html.twig', [
            'conditions' => $boardTypes,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/board/add')]
    public function addCondition(Request $request, BoardServices $boardServices)
    {
        $parameters = json_decode($request->getContent(), true);
        $newCondition = new Condition($parameters["conditionName"]);
        $boardServices->saveCondition($newCondition);
        return new JsonResponse(array('id' => $newCondition->getId(), 'name' => $newCondition->getName()));
    }
}
