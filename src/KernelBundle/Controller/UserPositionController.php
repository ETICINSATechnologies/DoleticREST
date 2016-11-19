<?php

namespace KernelBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use KernelBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use KernelBundle\Entity\UserPosition;
use KernelBundle\Form\UserPositionType;

class UserPositionController extends FOSRestController
{

    /**
     * Get all the user_positions
     * @return array
     *
     * @ApiDoc(
     *  section="UserPosition",
     *  description="Get all user_positions",
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
     * @Get("/user_positions")
     */
    public function getUserPositionsAction()
    {

        $user_positions = $this->getDoctrine()->getRepository("KernelBundle:UserPosition")
            ->findAll();

        return array('user_positions' => $user_positions);
    }

    /**
     * Get a user_position by ID
     * @param UserPosition $user_position
     * @return array
     *
     * @ApiDoc(
     *  section="UserPosition",
     *  description="Get a user_position",
     *  requirements={
     *      {
     *          "name"="user_position",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="user_position id"
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
     * @ParamConverter("user_position", class="KernelBundle:UserPosition")
     * @Get("/user_position/{id}", requirements={"id" = "\d+"})
     */
    public function getUserPositionAction(UserPosition $user_position)
    {

        return array('user_position' => $user_position);

    }

    /**
     * Get a user_position by user
     * @param User $user
     * @return array
     *
     * @ApiDoc(
     *  section="UserPosition",
     *  description="Get a user_position",
     *  requirements={
     *      {
     *          "name"="label",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="user_position user"
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
     * @ParamConverter("user", class="KernelBundle:User")
     * @Get("/user_position/user/{id}", requirements={"id" = "\d+"})
     */
    public function getUserPositionsByUserAction(User $user)
    {

        $user_positions = $this->getDoctrine()->getRepository('KernelBundle:UserPosition')
            ->findBy(['user' => $user]);

        return array('user_positions' => $user_positions);
    }

    /**
     * Create a new UserPosition
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="UserPosition",
     *  description="Create a new UserPosition",
     *  input="KernelBundle\Form\UserPositionType",
     *  output="KernelBundle\Entity\UserPosition",
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
     * @Post("/user_position")
     */
    public function postUserPositionAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_ADMIN');

        $user_position = new UserPosition();
        $form = $this->createForm(
            new UserPositionType(),
            $user_position
        );
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user_position);
            $em->flush();

            return array("user_position" => $user_position);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a UserPosition
     * Put action
     * @var Request $request
     * @var UserPosition $user_position
     * @return array
     *
     * @ApiDoc(
     *  section="UserPosition",
     *  description="Edit a UserPosition",
     *  requirements={
     *      {
     *          "name"="user_position",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="user_position id"
     *      }
     *  },
     *  input="KernelBundle\Form\UserPositionType",
     *  output="KernelBundle\Entity\UserPosition",
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
     * @ParamConverter("user_position", class="KernelBundle:UserPosition")
     * @Post("/user_position/{id}")
     */
    public function putUserPositionAction(Request $request, UserPosition $user_position)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_ADMIN');

        $form = $this->createForm(
            new UserPositionType(),
            $user_position
        );
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($user_position);
            $em->flush();

            return array("user_position" => $user_position);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Disable a UserPosition
     * Put action
     * @var Request $request
     * @var UserPosition $user_position
     * @return array
     *
     * @ApiDoc(
     *  section="UserPosition",
     *  description="Disable a UserPosition",
     *  requirements={
     *      {
     *          "name"="user_position",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="user_position id"
     *      }
     *  },
     *  input="KernelBundle\Form\UserPositionType",
     *  output="KernelBundle\Entity\UserPosition",
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
     * @ParamConverter("user_position", class="KernelBundle:UserPosition")
     * @Post("/user_position/{id}/disable")
     */
    public function disableUserPositionAction(Request $request, UserPosition $user_position)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_ADMIN');

        if ($user_position->isMain()) {
            return array(
                'error' => 'Impossible de désactiver le poste principal. Ajoutez un nouveau poste principal.',
            );
        }

        $user_position->setActive(false)->setEndDate(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($user_position);
        $em->flush();

        return array("user_position" => $user_position);
    }

    /**
     * Enable a UserPosition
     * Put action
     * @var Request $request
     * @var UserPosition $user_position
     * @return array
     *
     * @ApiDoc(
     *  section="UserPosition",
     *  description="Enable a UserPosition",
     *  requirements={
     *      {
     *          "name"="user_position",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="user_position id"
     *      }
     *  },
     *  input="KernelBundle\Form\UserPositionType",
     *  output="KernelBundle\Entity\UserPosition",
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
     * @ParamConverter("user_position", class="KernelBundle:UserPosition")
     * @Post("/user_position/{id}/enable")
     */
    public function enableUserPositionAction(Request $request, UserPosition $user_position)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_ADMIN');

        $user_position->setActive(true)->setEndDate(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user_position);
        $em->flush();

        return array("user_position" => $user_position);
    }

    /**
     * Delete a UserPosition
     * Delete action
     * @var UserPosition $user_position
     * @return array
     *
     * @View()
     * @ParamConverter("user_position", class="KernelBundle:UserPosition")
     * @Delete("/user_position/{id}")
     */
    public function deleteUserPositionAction(UserPosition $user_position)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($user_position);
        $em->flush();

        return array("status" => "Deleted");
    }

}