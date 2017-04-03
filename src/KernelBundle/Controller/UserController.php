<?php

namespace KernelBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\UserBundle\Model\UserInterface;
use KernelBundle\Entity\UserPosition;
use KernelBundle\Form\ChangePasswordType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use KernelBundle\Entity\User;
use KernelBundle\Form\UserType;

class UserController extends FOSRestController
{

    /**
     * Get all the users
     * @return array
     *
     * @ApiDoc(
     *  section="User",
     *  description="Get all users",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/users")
     */
    public function getUsersAction()
    {

        $users = $this->getDoctrine()->getRepository("KernelBundle:User")
            ->findAll();

        return array('users' => $users);
    }

    /**
     * Get all the current users
     * @return array
     *
     * @ApiDoc(
     *  section="User",
     *  description="Get all current users",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/users/current")
     */
    public function getCurrentUsersAction()
    {

        $users = $this->getDoctrine()->getRepository("KernelBundle:User")
            ->findUsersByOld(false);

        return array('users' => $users);
    }

    /**
     * Get all the users
     * @return array
     *
     * @ApiDoc(
     *  section="User",
     *  description="Get all old users",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/users/old")
     */
    public function getOldUsersAction()
    {

        $users = $this->getDoctrine()->getRepository("KernelBundle:User")
            ->findUsersByOld(true);

        return array('users' => $users);
    }

    /**
     * Get all the disabled users
     * @return array
     *
     * @ApiDoc(
     *  section="User",
     *  description="Get all disabled users",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/users/disabled")
     */
    public function getDisabledUsersAction()
    {

        $users = $this->getDoctrine()->getRepository("KernelBundle:User")
            ->findBy(['enabled' => false]);

        return array('users' => $users);
    }

    /**
     * Get all the users
     * @return array
     *
     * @ApiDoc(
     *  section="User",
     *  description="Get current user",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/user/current")
     */
    public function getCurrentUserAction()
    {

        $user = $this->getUser();

        return array('user' => $user);
    }

    /**
     * Get a user by ID
     * @param User $user
     * @return array
     *
     * @ApiDoc(
     *  section="User",
     *  description="Get a user",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("user", class="KernelBundle:User")
     * @Get("/user/{id}", requirements={"id" = "\d+"})
     */
    public function getUserAction(User $user)
    {

        return array('user' => $user);

    }

    /**
     * Get a user by email
     * @param string $email
     * @return array
     *
     * @ApiDoc(
     *  section="User",
     *  description="Get a user",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/user/{email}", requirements={"email" = "\S+@\S+\.\S+"})
     */
    public function getUserByMailAction($email)
    {

        $user = $this->getDoctrine()->getRepository('KernelBundle:User')->findOneBy(['email' => $email]);
        return array('user' => $user);

    }

    /**
     * Get a user by email
     * @param string $username
     * @return array
     *
     * @ApiDoc(
     *  section="User",
     *  description="Get a user",
     *  requirements={
     *      {
     *          "name"="username",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="user username"
     *      }
     *  },
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/user/{username}")
     */
    public function getUserByUsernameAction($username)
    {

        $user = $this->getDoctrine()->getRepository('KernelBundle:User')->findOneBy(['username' => $username]);
        return array('user' => $user);

    }

    /**
     * Create a new User
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="User",
     *  description="Create a new User",
     *  input="KernelBundle\Form\UserType",
     *  output="KernelBundle\Entity\User",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @Post("/user")
     */
    public function postUserAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $user = new User();
        $form = $this->createForm(new UserType(), $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $position = $user->getMainPosition();
            $em = $this->getDoctrine()->getManager();
            if (isset($position)) {
                $userPosition = new UserPosition();
                $userPosition->setActive(true)->setMain(true)->setPosition($position);
                $user->setPositions([$userPosition]);
                $userPosition->setUser($user);
                $em->persist($user);
                $em->persist($userPosition);
            } else {
                $em->persist($user);
            }
            $em->flush();

            return array("user" => $user);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a User
     * Put action
     * @var Request $request
     * @var User $user
     * @return array
     *
     * @ApiDoc(
     *  section="User",
     *  description="Edit a User",
     *  input="KernelBundle\Form\UserType",
     *  output="KernelBundle\Entity\User",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("user", class="KernelBundle:User")
     * @Post("/user/{id}", requirements={"id" = "\d+"})
     */
    public function putUserAction(Request $request, User $user)
    {

        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $form = $this->createForm(new UserType(), $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            return array("user" => $user);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit current User
     * Put action
     * @param Request $request
     * @return array
     *
     * @ApiDoc(
     *  section="User",
     *  description="Edit current User",
     *  input="KernelBundle\Form\UserType",
     *  output="KernelBundle\Entity\User",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Post("/user/current")
     */
    public function putCurrentUserAction(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(new UserType(), $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            return array("user" => $user);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit current User password
     * Put action
     * @param Request $request
     * @return array
     *
     * @ApiDoc(
     *  section="User",
     *  description="Edit current User password",
     *  input="KernelBundle\Form\ChangePasswordType",
     *  output="KernelBundle\Entity\User",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Post("/user/current/password")
     */
    public function changePasswordAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $defaultData = [];

        $form = $this->createForm(new ChangePasswordType(), $defaultData);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user->setPlainPassword($data['new']);
            $this->get('fos_user.user_manager')->updateUser($user);
            if ($this->container->getParameter('mailer_password') !== null) {
                $message = new \Swift_Message();
                $message
                    ->setSubject('Ton mot de passe Doletic a été modifié.')
                    ->setFrom($this->container->getParameter('mailer_user'))
                    ->setTo($user->getEmail())
                    ->setBody($this->container->get('templating')->render(
                        ':emails:update_pass.html.twig',
                        [
                            'user' => $user
                        ]
                    ));

                $this->get('mailer')->send($message);
            }
            return array("status" => "Updated");
        }
        return array("form" => $form);

    }

    /**
     * Disable a User
     * Post action
     * @var User $user
     * @return array
     *
     * @ApiDoc(
     *  section="User",
     *  description="Disable a user",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("user", class="KernelBundle:User")
     * @Post("/user/{id}/disable", requirements={"id" = "\d+"})
     */
    public function disableUserAction(User $user)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $user->setEnabled(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return array("user" => $user);
    }

    /**
     * Enable a User
     * Post action
     * @var User $user
     * @return array
     *
     * @ApiDoc(
     *  section="User",
     *  description="Enable a user",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("user", class="KernelBundle:User")
     * @Post("/user/{id}/enable", requirements={"id" = "\d+"})
     */
    public function enableUserAction(User $user)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $user->setEnabled(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return array("user" => $user);
    }


    /**
     * Delete a User
     * Delete action
     * @var User $user
     * @return array
     *
     * @ApiDoc(
     *  section="User",
     *  description="Delete a user",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("user", class="KernelBundle:User")
     * @Delete("/user/{id}", requirements={"id" = "\d+"})
     */
    public function deleteUserAction(User $user)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return array("status" => "Deleted");
    }

}