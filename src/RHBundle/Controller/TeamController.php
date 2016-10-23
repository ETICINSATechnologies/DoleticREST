<?php

namespace RHBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use RHBundle\Entity\Team;
use RHBundle\Form\TeamType;

class TeamController extends FOSRestController
{

    /**
     * Get all the teams
     * @return array
     *
     * @ApiDoc(
     *  section="Team",
     *  description="Get all teams",
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
     * @Get("/teams")
     */
    public function getTeamsAction(){

        $teams = $this->getDoctrine()->getRepository("RHBundle:Team")
            ->findAll();

        return array('teams' => $teams);
    }

    /**
     * Get a team by ID
     * @param Team $team
     * @return array
     *
     * @ApiDoc(
     *  section="Team",
     *  description="Get a team",
     *  requirements={
     *      {
     *          "name"="team",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="team id"
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
     * @ParamConverter("team", class="RHBundle:Team")
     * @Get("/team/{id}", requirements={"id" = "\d+"})
     */
    public function getTeamAction(Team $team){

        return array('team' => $team);

    }

    /**
     * Get a team by name
     * @param string $name
     * @return array
     *
     * @ApiDoc(
     *  section="Team",
     *  description="Get a team",
     *  requirements={
     *      {
     *          "name"="name",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="team name"
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
     * @Get("/team/{name}")
     */
    public function getTeamByLabelAction($name){

        $team = $this->getDoctrine()->getRepository('RHBundle:Team')->findOneBy(['name' => $name]);
        return array('team' => $team);
    }

    /**
     * Create a new Team
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="Team",
     *  description="Create a new Team",
     *  input="RHBundle\Form\TeamType",
     *  output="RHBundle\Entity\Team",
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
     * @Post("/team")
     */
    public function postTeamAction(Request $request)
    {
        $team = new Team();
        $form = $this->createForm(new TeamType(), $team);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();

            return array("team" => $team);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a Team
     * Put action
     * @var Request $request
     * @var Team $team
     * @return array
     *
     * @ApiDoc(
     *  section="Team",
     *  description="Edit a Team",
     *  requirements={
     *      {
     *          "name"="team",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="team id"
     *      }
     *  },
     *  input="RHBundle\Form\TeamType",
     *  output="RHBundle\Entity\Team",
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
     * @ParamConverter("team", class="RHBundle:Team")
     * @Put("/team/{id}")
     */
    public function putTeamAction(Request $request, Team $team)
    {
        $form = $this->createForm(new TeamType(), $team);
        $form->submit($request);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($team);
            $em->flush();

            return array("team" => $team);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a Team
     * Delete action
     * @var Team $team
     * @return array
     *
     * @View()
     * @ParamConverter("team", class="RHBundle:Team")
     * @Delete("/team/{id}")
     */
    public function deleteTeamAction(Team $team)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($team);
        $em->flush();

        return array("status" => "Deleted");
    }

}