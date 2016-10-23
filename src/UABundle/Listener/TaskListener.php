<?php

namespace UABundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use UABundle\Entity\Task;

class TaskListener
{
    // Create number using existing numbers
    public function prePersist(Task $task, LifecycleEventArgs $event)
    {

    }

    public function preUpdate(Task $task, LifecycleEventArgs $event)
    {

    }
}