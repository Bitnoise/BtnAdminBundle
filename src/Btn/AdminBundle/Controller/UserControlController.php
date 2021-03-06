<?php

namespace Btn\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Btn\AdminBundle\Annotation\Crud;
use Btn\AdminBundle\Model\UserInterface;

/**
 * @Route("/user")
 * @Crud(formHandlerId="btn_admin.form.handler.user_form")
 */
class UserControlController extends CrudController
{
    /**
     * @Route("/profile", name="btn_admin_usercontrol_profile", methods={"GET", "POST"})
     * @Template()
     */
    public function profileAction(Request $request)
    {
        $this->checkUserAccessOrThrowAccessDeniedException();

        $form = $this->createForm('btn_admin_form_profile_control', $this->getUser(), array(
            'action' => $this->generateUrl('btn_admin_usercontrol_profile'),
            'legend' => 'btn_admin_usercontrol_profile',
        ));

        if ($this->handleForm($form, $request)) {
            $this->setFlash('btn_admin.flash.updated');

            return $this->redirect($this->generateUrl('btn_admin_usercontrol_profile'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/change-password", name="btn_admin_usercontrol_changepassword", methods={"GET", "POST"})
     * @Template()
     */
    public function changePasswordAction(Request $request)
    {
        $this->checkUserAccessOrThrowAccessDeniedException();

        $form = $this->createForm('btn_admin_form_change_password_control', $this->getUser(), array(
            'action' => $this->generateUrl('btn_admin_usercontrol_changepassword'),
            'legend' => 'btn_admin_usercontrol_changepassword',
        ));

        if ($this->handleForm($form, $request)) {
            $this->setFlash('btn_admin.flash.updated');

            return $this->redirect($this->generateUrl('btn_admin_usercontrol_profile'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     *
     */
    protected function checkUserAccessOrThrowAccessDeniedException()
    {
        $user = $this->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw $this->createAccessDeniedException('This user does not have access to this section.');
        }
    }
}
