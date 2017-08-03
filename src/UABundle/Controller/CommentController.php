<?php

namespace UABundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use GRCBundle\Entity\Contact;
use GRCBundle\Entity\Firm;
use KernelBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use UABundle\Entity\Comment;
use UABundle\Entity\CommentField;
use UABundle\Entity\CommentManager;
use UABundle\Entity\CommentOrigin;
use UABundle\Entity\Project;
use UABundle\Form\CommentType;

class CommentController extends FOSRestController
{

    /**
     * Get a comment by ID
     * @param Comment $comment
     * @return array
     *
     * @ApiDoc(
     *  section="Comment",
     *  description="Get a comment",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("comment", class="UABundle:Comment")
     * @Get("/comment/{id}", requirements={"id" = "\d+"})
     */
    public function getCommentAction(Comment $comment)
    {

        return array('comment' => $comment);

    }

    /**
     * Get all comments by Project
     * @param $project
     * @return array
     * @internal param $id
     * @internal param Project $project
     * @ApiDoc(
     *  section="Comment",
     *  description="Get a comment",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/comments/{project}", requirements={"project" = "\d+"})
     */
    public function getAllCommentsByProjectAction($project)
    {
        /** @var Project project */
        $comments = $this->getDoctrine()->getManager()->getRepository("UABundle:Project")
            ->findAllByProject($project);
        return array("comments" => $comments);

    }


    /**
     * Create a new Comment
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="Comment",
     *  description="Create a new Comment",
     *  input="UABundle\Form\CommentType",
     *  output="UABundle\Entity\Comment",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @Post("/comment")
     */
    public function postCommentAction(Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_UA_ADMIN');

        $comment = new Comment();
        $form = $this->createForm(new CommentType(), $comment, []);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return array("comment" => $comment);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a Comment
     * Delete action
     * @var Comment $comment
     * @return array
     *
     * @ApiDoc(
     *  section="Comment",
     *  description="Delete a comment",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("comment", class="UABundle:Comment")
     * @Delete("/comment/{id}", requirements={"id" = "\d+"})
     */
    public function deleteCommentAction(Comment $comment)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();

        return array("status" => "Deleted");
    }

}