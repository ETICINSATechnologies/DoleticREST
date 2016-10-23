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
use RHBundle\Entity\UserData;
use RHBundle\Form\UserDataType;

class UserDataController extends FOSRestController
{

    /**
     * Get all the user_datas
     * @return array
     *
     * @ApiDoc(
     *  section="UserData",
     *  description="Get all user_datas",
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
     * @Get("/user_datas")
     */
    public function getUserDatasAction(){

        $user_datas = $this->getDoctrine()->getRepository("RHBundle:UserData")
            ->findAll();

        return array('user_datas' => $user_datas);
    }

    /**
     * Get a user_data by ID
     * @param UserData $user_data
     * @return array
     *
     * @ApiDoc(
     *  section="UserData",
     *  description="Get a user_data",
     *  requirements={
     *      {
     *          "name"="user_data",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="user_data id"
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
     * @ParamConverter("user_data", class="RHBundle:UserData")
     * @Get("/user_data/{id}", requirements={"id" = "\d+"})
     */
    public function getUserDataAction(UserData $user_data){

        return array('user_data' => $user_data);

    }

    /**
     * Get a user_data by label
     * @param string $label
     * @return array
     *
     * @ApiDoc(
     *  section="UserData",
     *  description="Get a user_data",
     *  requirements={
     *      {
     *          "name"="label",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="user_data label"
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
     * @Get("/user_data/{label}")
     */
    public function getUserDataByLabelAction($label){

        $user_data = $this->getDoctrine()->getRepository('RHBundle:UserData')->findOneBy(['label' => $label]);
        return array('user_data' => $user_data);
    }

    /**
     * Create a new UserData
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="UserData",
     *  description="Create a new UserData",
     *  input="RHBundle\Form\UserDataType",
     *  output="RHBundle\Entity\UserData",
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
     * @Post("/user_data")
     */
    public function postUserDataAction(Request $request)
    {
        $user_data = new UserData();
        $form = $this->createForm(new UserDataType(), $user_data);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user_data);
            $em->flush();

            return array("user_data" => $user_data);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a UserData
     * Put action
     * @var Request $request
     * @var UserData $user_data
     * @return array
     *
     * @ApiDoc(
     *  section="UserData",
     *  description="Edit a UserData",
     *  requirements={
     *      {
     *          "name"="user_data",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="user_data id"
     *      }
     *  },
     *  input="RHBundle\Form\UserDataType",
     *  output="RHBundle\Entity\UserData",
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
     * @ParamConverter("user_data", class="RHBundle:UserData")
     * @Put("/user_data/{id}")
     */
    public function putUserDataAction(Request $request, UserData $user_data)
    {
        $form = $this->createForm(new UserDataType(), $user_data);
        $form->submit($request);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($user_data);
            $em->flush();

            return array("user_data" => $user_data);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a UserData
     * Delete action
     * @var UserData $user_data
     * @return array
     *
     * @View()
     * @ParamConverter("user_data", class="RHBundle:UserData")
     * @Delete("/user_data/{id}")
     */
    public function deleteUserDataAction(UserData $user_data)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user_data);
        $em->flush();

        return array("status" => "Deleted");
    }

}