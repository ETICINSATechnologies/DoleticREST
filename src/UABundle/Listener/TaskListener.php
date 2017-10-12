<?php

namespace UABundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UABundle\Entity\Task;

class TaskListener
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function prePersist(Task $task, LifecycleEventArgs $event)
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $lastTask = $entityManager->getRepository('UABundle:Task')->findBy(['project' => $task->getProject()], ['number' => 'DESC'], 1);
        $number = 1;
        if(isset($lastTask) && !empty($lastTask)) {
            $number = $lastTask[max(array_keys($lastTask))]->getNumber() + 1;
        }
        $task->setNumber($number);
    }

    public function preRemove(Task $task, LifecycleEventArgs $event)
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $tasks = $entityManager->getRepository('UABundle:Task')->findBy(['project' => $task->getProject()], ['number' => 'ASC']);
        if(isset($tasks) && !empty($tasks)) {
            $n = 1;
            foreach ($tasks as $currentTask) {
                if ($currentTask->getNumber() != $n) {
                    $currentTask->setNumber($n);
                    $entityManager->persist($currentTask);
                }
                if($currentTask->getId() != $task->getId()) {
                    $n++;
                }
            }
        }
    }
}