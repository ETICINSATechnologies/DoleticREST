<?php

namespace UABundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use UABundle\Entity\Project;
use UABundle\Entity\Task;
use UABundle\Form\TaskType;

class TaskController extends FOSRestController
{

    /**
     * Get all the tasks
     * @return array
     *
     * @ApiDoc(
     *  section="Task",
     *  description="Get all tasks",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  }
     * )
     *
     * @View()
     * @Get("/tasks")
     */
    public function getTasksAction()
    {

        $tasks = $this->getDoctrine()->getRepository("UABundle:Task")
            ->findBy([], ['number' => 'ASC']);

        return array('tasks' => $tasks);
    }

    /**
     * Get all the tasks in a project
     * @param Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="Task",
     *  description="Get all tasks in a project",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("project", class="UABundle:Project")
     * @Get("/tasks/project/{id}", requirements={"id" = "\d+"})
     */
    public function getTasksByProjectAction(Project $project)
    {

        $tasks = $this->getDoctrine()->getRepository("UABundle:Task")
            ->findBy(['project' => $project], ['number' => 'ASC']);

        return array('tasks' => $tasks);
    }

    /**
     * Get a task by ID
     * @param Task $task
     * @return array
     *
     * @ApiDoc(
     *  section="Task",
     *  description="Get a task",
     *  requirements={
     *      {
     *          "name"="task",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="task id"
     *      }
     *  },
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("task", class="UABundle:Task")
     * @Get("/task/{id}", requirements={"id" = "\d+"})
     */
    public function getTaskAction(Task $task)
    {

        return array('task' => $task);

    }

    /**
     * Create a new Task
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="Task",
     *  description="Create a new Task",
     *  input="UABundle\Form\TaskType",
     *  output="UABundle\Entity\Task",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  },
     *  views = { "premium" }
     * )
     *
     * @View()
     * @Post("/task")
     */
    public function postTaskAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(new TaskType(), $task);
        $form->handleRequest($request);

        if ($this->get('ua.project.rights_service')->userHasRights($this->getUser(), $task->getProject())) {
            throw new AccessDeniedException();
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $task->setEnded(false);
            $em->persist($task);
            $em->flush();

            return array("task" => $task);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a Task
     * Put action
     * @var Request $request
     * @var Task $task
     * @return array
     *
     * @ApiDoc(
     *  section="Task",
     *  description="Edit a Task",
     *  requirements={
     *      {
     *          "name"="task",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="task id"
     *      }
     *  },
     *  input="UABundle\Form\TaskType",
     *  output="UABundle\Entity\Task",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  },
     *  views = { "premium" }
     * )
     *
     * @View()
     * @ParamConverter("task", class="UABundle:Task")
     * @Post("/task/{id}")
     */
    public function putTaskAction(Request $request, Task $task)
    {
        if ($this->get('ua.project.rights_service')->userHasRights($this->getUser(), $task->getProject())) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new TaskType(), $task);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($task);
            $em->flush();

            return array("task" => $task);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * End a Task
     * Put action
     * @var Request $request
     * @var Task $task
     * @return array
     *
     * @ApiDoc(
     *  section="Task",
     *  description="End a Task",
     *  requirements={
     *      {
     *          "name"="task",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="task id"
     *      }
     *  },
     *  input="UABundle\Form\TaskType",
     *  output="UABundle\Entity\Task",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  },
     *  views = { "premium" }
     * )
     *
     * @View()
     * @ParamConverter("task", class="UABundle:Task")
     * @Post("/task/{id}/end")
     */
    public function endTaskAction(Request $request, Task $task)
    {
        if ($this->get('ua.project.rights_service')->userHasRights($this->getUser(), $task->getProject())) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $task->setEnded(true);
        $em->persist($task);
        $em->flush();

        return array("task" => $task);
    }


    /**
     * Cancel the end of a Task
     * Put action
     * @var Request $request
     * @var Task $task
     * @return array
     *
     * @ApiDoc(
     *  section="Task",
     *  description="Cancel the end of a Task",
     *  requirements={
     *      {
     *          "name"="task",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="task id"
     *      }
     *  },
     *  input="UABundle\Form\TaskType",
     *  output="UABundle\Entity\Task",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  },
     *  views = { "premium" }
     * )
     *
     * @View()
     * @ParamConverter("task", class="UABundle:Task")
     * @Post("/task/{id}/unend")
     */
    public function unendTaskAction(Request $request, Task $task)
    {
        if ($this->get('ua.project.rights_service')->userHasRights($this->getUser(), $task->getProject())) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $task->setEnded(false);
        $em->persist($task);
        $em->flush();

        return array("task" => $task);
    }

    /**
     * Switch a Task number with another one
     * Put action
     * @var Request $request
     * @var Task $task
     * @return array
     *
     * @ApiDoc(
     *  section="Task",
     *  description="Switch a Task number with another one",
     *  requirements={
     *      {
     *          "name"="task",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="task id"
     *      }
     *  },
     *  input="UABundle\Form\TaskType",
     *  output="UABundle\Entity\Task",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  },
     *  views = { "premium" }
     * )
     *
     * @View()
     * @ParamConverter("task", class="UABundle:Task")
     * @Post("/task/{id}/switch/{idBis}")
     */
    public function switchTasksAction(Request $request, Task $task, $idBis)
    {
        if ($this->get('ua.project.rights_service')->userHasRights($this->getUser(), $task->getProject())) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $taskBis = $em->getRepository('UABundle:Task')->find($idBis);
        $numBis = $taskBis->getNumber();
        $taskBis->setNumber($task->getNumber());
        $task->setNumber($numBis);
        $em->persist($task);
        $em->persist($taskBis);
        $em->flush();

        return array("task" => $task);
    }

    /**
     * Delete a Task
     * Delete action
     * @var Task $task
     * @return array
     *
     * @View()
     * @ParamConverter("task", class="UABundle:Task")
     * @Delete("/task/{id}")
     */
    public function deleteTaskAction(Task $task)
    {
        if ($this->get('ua.project.rights_service')->userHasRights($this->getUser(), $task->getProject())) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        return array("status" => "Deleted");
    }

}