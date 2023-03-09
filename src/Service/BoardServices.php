<?php

namespace App\Service;

use App\Entity\Condition;
use Doctrine\ORM\EntityManagerInterface;

class BoardServices extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    public function getAllConditions()
    {
        return $this->entityManager->getRepository(Condition::class)->findAll();
    }

    public function saveCondition(Condition $newCondition): void
    {
        $this->entityManager->getRepository(Condition::class)->save($newCondition, true);
    }
    
}