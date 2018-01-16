<?php

namespace RHBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use KernelBundle\Entity\Division;
use KernelBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Finder\Exception\AccessDeniedException;
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
     *   "rh" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/teams")
     */
    public function getTeamsAction()
    {

        $teams = $this->getDoctrine()->getRepository("RHBundle:Team")
            ->findAll();

        $array = [];
        foreach ($teams as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the teams in a division
     * @param Division $division
     * @return array
     *
     * @ApiDoc(
     *  section="Team",
     *  description="Get all teams in a division",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("division", class="KernelBundle:Division")
     * @Get("/teams/division/{id}", requirements={"id" = "\d+"})
     */
    public function getTeamsByDivisionAction(Division $division)
    {

        $teams = $this->getDoctrine()->getRepository("RHBundle:Team")
            ->findBy(['division' => $division]);

        $array = [];
        foreach ($teams as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the teams let by a User
     * @param User $leader
     * @return array
     *
     * @ApiDoc(
     *  section="Team",
     *  description="Get all teams led by a User",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("leader", class="KernelBundle:User")
     * @Get("/teams/leader/{id}", requirements={"id" = "\d+"})
     */
    public function getTeamsByLeaderAction(User $leader)
    {

        $teams = $this->getDoctrine()->getRepository("RHBundle:Team")
            ->findBy(['leader' => $leader]);

        $array = [];
        foreach ($teams as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the teams a User belongs to
     * @param User $member
     * @return array
     *
     * @ApiDoc(
     *  section="Team",
     *  description="Get all teams a User belongs to",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("member", class="KernelBundle:User")
     * @Get("/teams/member/{id}", requirements={"id" = "\d+"})
     */
    public function getTeamsByMemberAction(User $member)
    {

        $teams = $this->getDoctrine()->getRepository("RHBundle:Team")
            ->findUserTeams($member);

        $array = [];
        foreach ($teams as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get a team by ID
     * @param Team $team
     * @return array
     *
     * @ApiDoc(
     *  section="Team",
     *  description="Get a team",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("team", class="RHBundle:Team")
     * @Get("/team/{id}", requirements={"id" = "\d+"})
     */
    public function getTeamAction(Team $team)
    {

        return $team;

    }

    /**
     * Get a team by name
     * @param string $name
     * @return array
     *
     * @ApiDoc(
     *  section="Team",
     *  description="Get a team",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/team/{name}")
     */
    public function getTeamByNameAction($name)
    {

        $team = $this->getDoctrine()->getRepository('RHBundle:Team')->findOneBy(['name' => $name]);
        return $team;
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
     *   "rh" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @Post("/team")
     */
    public function postTeamAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_ADMIN');

        $team = new Team();
        $form = $this->createForm(new TeamType(), $team);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();

            return $team;

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
     *  input="RHBundle\Form\TeamType",
     *  output="RHBundle\Entity\Team",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("team", class="RHBundle:Team")
     * @Post("/team/{id}", requirements={"id" = "\d+"})
     */
    public function putTeamAction(Request $request, Team $team)
    {

        if (!$this->get('rh.team.rights_service')->userHasRights($this->getUser(), $team)) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new TeamType(), $team);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($team);
            $em->flush();

            return $team;
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
     * @ApiDoc(
     *  section="Team",
     *  description="Delete a Team",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("team", class="RHBundle:Team")
     * @Delete("/team/{id}", requirements={"id" = "\d+"})
     */
    public function deleteTeamAction(Team $team)
    {
        if (!$this->get('rh.team.rights_service')->userHasRights($this->getUser(), $team)) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($team);
        $em->flush();

        return array("status" => "Deleted");
    }

}