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
use Symfony\Component\HttpFoundation\Request;
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
    public function getTasksAction(){

        $tasks = $this->getDoctrine()->getRepository("UABundle:Task")
            ->findAll();

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
    public function getTaskAction(Task $task){

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
     * @Put("/task/{id}")
     */
    public function putTaskAction(Request $request, Task $task)
    {
        $form = $this->createForm(new TaskType(), $task);
        $form->submit($request);
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
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        return array("status" => "Deleted");
    }

}