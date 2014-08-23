<?php

namespace Btn\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Btn\AdminBundle\Model\UserInterface;

/**
 * @Route("/profile")
 */
class ProfileControlController extends AbstractControlController
{
    /**
     * @Route("/", name="btn_admin_profilecontrol_index")
     */
    public function indexAction(Request $request)
    {
        return $this->forward('BtnAdminBundle:Profile:edit', array('requser' => $requset));
    }

    /**
     * @Route("/edit", name="btn_admin_profilecontrol_edit", methods={"GET"})
     * @Route("/update", name="btn_admin_profilecontrol_update", methods={"POST"})
     * @Template()
     */
    public function updateAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->createForm('btn_admin_form_profile_control', $user, array(
            'action' => $this->generateUrl('btn_admin_profilecontrol_update'),
            'legend' => 'btn_admin_profilecontrol_edit',
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $um = $this->get('fos_user.user_manager');
            $um->updateUser($user);
            $um->reloadUser($user);

            $this->setFlash('btn_admin.flash.updated');

            return $this->redirect($this->generateUrl('btn_admin_profilecontrol_edit'));
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
