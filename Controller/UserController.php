<?php

namespace Btn\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * The user index view
     *
     * @Route("/", name="btn_admin_user_index")
     */
    public function indexAction()
    {
        return $this->forward('BtnAdminBundle:User:list');
    }

    /**
     * The user list view
     *
     * @Route("/list", name="btn_admin_user_list")
     * @Template()
     */
    public function listAction()
    {
        $userClass = $this->container->getParameter('btn_admin.user_class');
        $users = $this->getDoctrine()->getRepository($userClass)->findAll();

        return array('users' => $users);
    }

    /**
     * The user new view
     *
     * @Route("/new", name="btn_admin_user_new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $userClass = $this->container->getParameter('btn_admin.user_class');
        $user = new $userClass();
        $form = $this->createForm('btn_admin_user_add', $user);

        return array(
            'user' => $user,
            'form' => $form->createView()
        );
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/", name="btn_admin_user_create")
     * @Method("POST")
     * @Template("BtnControlBundle:User:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $um = $this->get('fos_user.user_manager');

        $entity = $um->createUser();
        $entity->setEnabled(true);
        $form   = $this->createForm('btn_admin_user_add', $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $um->updateUser($entity);

            $msg = $this->get('translator')->trans('btn_admin.flash.added');
            $this->getRequest()->getSession()->getFlashBag()->set('success', $msg);

            return $this->redirect($this->generateUrl('btn_admin_user_list'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="btn_admin_user_edit")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $userClass  = $this->container->getParameter('btn_admin.user_class');
        $user       = $this->getDoctrine()->getRepository($userClass)->findOneById($id);
        $deleteForm = $this->createForm('btn_admin_delete', array('id' => $id));
        $form       = $this->createForm('btn_admin_edit', $user);

        return array(
            'user'        => $user,
            'delete_form' => $deleteForm->createView(),
            'form'        => $form->createView()
        );
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}", name="btn_admin_user_update")
     * @Method("POST")
     * @Template("BtnControlBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $um = $this->get('fos_user.user_manager');

        $userClass = $this->container->getParameter('btn_admin.user_class');
        $entity    = $em->getRepository($userClass)->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createForm('btn_admin_delete', array('id' => $id));
        $editForm   = $this->createForm('btn_admin_edit', $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $um->updateUser($entity);

            $msg = $this->get('translator')->trans('btn_admin.flash.updated');
            $this->getRequest()->getSession()->getFlashBag()->set('success', $msg);

            return $this->redirect($this->generateUrl('btn_admin_user_list'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a User entity.
     *
     * @Route("/{id}/delete", name="btn_admin_user_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createForm('btn_admin_delete', array('id' => $id));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em        = $this->getDoctrine()->getManager();
            $userClass = $this->container->getParameter('btn_admin.user_class');
            $entity    = $em->getRepository($userClass)->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $msg = $this->get('translator')->trans('btn_admin.flash.deleted');
            $this->getRequest()->getSession()->getFlashBag()->set('success', $msg);

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('btn_admin_user_list'));
    }
}
