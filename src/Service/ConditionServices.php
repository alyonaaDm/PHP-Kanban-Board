<?php

namespace App\Service;

use App\Entity\Condition;
use App\Entity\Task;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class ConditionServices extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    public function getConditionByName(string $conditionName): Condition
    {
        return $this->entityManager->getRepository(Condition::class)->findOneBy(['name' => $conditionName]);
    }
}