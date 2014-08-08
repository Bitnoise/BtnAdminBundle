<?php

namespace Btn\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Btn\AdminBundle\Entity\User;

/**
 * Movie controller.
 *
 * @Route("/control")
 */
class DefaultController extends Controller
{
    /**
     * The default admin panel view
     *
     * @Route("/", name="cp_homepage")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * The user list view
     *
     * @Route("/profile/list", name="btn_admin_users_list")
     * @Template()
     */
    public function usersListAction()
    {
        $users = $this->getDoctrine()->getRepository('BtnAdminBundle:User')->findAll();

        return array('users' => $users);
    }

    /**
     * The user new view
     *
     * @Route("/profile/new", name="btn_admin_user_new")
     * @Template()
     */
    public function userNewAction(Request $request)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setEnabled(true);
        $form = $formFactory->createForm();
        $form->setData($user);

        if ('POST' === $request->getMethod()) {
            $form->bind($request);
            if ($form->isValid()) {
                $userManager->updateUser($user);

                $msg = $this->get('translator')->trans('btn_control.flash.added');
                $this->getRequest()->getSession()->getFlashBag()->set('success', $msg);

                return $this->redirect($this->generateUrl('btn_admin_users_list'));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * The user edit view
     *
     * @Route("/profile/{id}/edit", name="btn_admin_user_edit")
     * @Template()
     */
    public function userEditAction(Request $request, $id)
    {
        $user       = $this->getDoctrine()->getRepository('BtnAdminBundle:User')->findById($id);
        $deleteForm = $this->createDeleteForm($id);

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('fos_user.profile.form.factory');
        $form        = $formFactory->createForm();
        $form->setData($user[0]);
        if ('POST' === $request->getMethod()) {
            $form->bind($request);
            if ($form->isValid()) {
                /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
                $userManager = $this->container->get('fos_user.user_manager');
                $userManager->updateUser($user[0]);

                $msg = $this->get('translator')->trans('btn_control.flash.updated');
                $this->getRequest()->getSession()->getFlashBag()->set('success', $msg);

                return $this->redirect($this->generateUrl('btn_admin_users_list'));
            }
        }

        return array(
            'user' => $user[0],
            'delete_form' => $deleteForm->createView(),
            'form' => $form->createView()
        );
    }

    /**
     * Deletes user
     *
     * @Route("/profile/{id}/delete", name="btn_admin_user_delete")
     * @Method("POST")
     */
    public function userDeleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BtnAdminBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();

            $msg = $this->get('translator')->trans('btn_control.flash.deleted');
            $this->getRequest()->getSession()->getFlashBag()->set('success', $msg);
        }

        return $this->redirect($this->generateUrl('btn_admin_users_list'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

}
