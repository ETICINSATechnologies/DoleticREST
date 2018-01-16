<?php

namespace RHBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use KernelBundle\Entity\Division;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use RHBundle\Entity\Team;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use RHBundle\Entity\TeamMember;
use RHBundle\Form\TeamMemberType;

class TeamMemberController extends FOSRestController
{

    /**
     * Get all the team_members
     * @return array
     *
     * @ApiDoc(
     *  section="TeamMember",
     *  description="Get all team_members",
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
     * @Get("/team_members")
     */
    public function getTeamMembersAction()
    {

        $team_members = $this->getDoctrine()->getRepository("RHBundle:TeamMember")
            ->findAll();

        $array = [];
        foreach ($team_members as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the members in a team
     * @param Team $team
     * @return array
     *
     * @ApiDoc(
     *  section="TeamMember",
     *  description="Get all team_members",
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
     * @Get("/team_members/{id}", requirements={"id" = "\d+"})
     */
    public function getTeamMembersByTeamAction(Team $team)
    {

        $team_members = $this->getDoctrine()->getRepository("RHBundle:TeamMember")
            ->findBy(['team' => $team]);

        $array = [];
        foreach ($team_members as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get a teamMember by ID
     * @param TeamMember $teamMember
     * @return array
     *
     * @ApiDoc(
     *  section="TeamMember",
     *  description="Get a teamMember",
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
     * @ParamConverter("teamMember", class="RHBundle:TeamMember")
     * @Get("/team_member/{id}", requirements={"id" = "\d+"})
     */
    public function getTeamMemberAction(TeamMember $teamMember)
    {

        return $teamMember;

    }

    /**
     * Create a new TeamMember
     * @var Request $request
     * @param Team $team
     * @return View|array
     *
     * @ApiDoc(
     *  section="TeamMember",
     *  description="Create a new TeamMember",
     *  input="RHBundle\Form\TeamMemberType",
     *  output="RHBundle\Entity\TeamMember",
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
     * @Post("/team_member/{id}", requirements={"id" = "\d+"})
     */
    public function postTeamMemberAction(Request $request, Team $team)
    {
        if (!$this->get('rh.team.rights_service')->userHasRights($this->getUser(), $team)) {
            throw new AccessDeniedException();
        }

        $teamMember = new TeamMember();
        $teamMember->setTeam($team);
        $form = $this->createForm(new TeamMemberType(), $teamMember);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($teamMember);
            $em->flush();

            return $teamMember;

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a TeamMember
     * Delete action
     * @var TeamMember $teamMember
     * @return array
     *
     * @ApiDoc(
     *  section="TeamMember",
     *  description="Delete a TeamMember",
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
     * @ParamConverter("teamMember", class="RHBundle:TeamMember")
     * @Delete("/team_member/{id}", requirements={"id" = "\d+"})
     */
    public function deleteTeamMemberAction(TeamMember $teamMember)
    {
        if (!$this->get('rh.team.rights_service')->userHasRights($this->getUser(), $teamMember->getTeam())) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($teamMember);
        $em->flush();

        return array("status" => "Deleted");
    }

}