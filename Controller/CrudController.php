<?php

namespace Btn\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 *
 */
class CrudController extends AbstractCrudController
{
    /**
     * @Route("/", methods={"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $repo     = $this->getEntityProvider()->getRepository();
        $entities = $repo->findAll();

        return $this->render($this->crudSettings->getIndexTemplate(), array(
            'list_header'  => $this->getTransKeyFromRoute(),
            'pagination'   => $this->paginate($entities),
            'route_index'  => $this->getPrefixedRoute('index'),
            'route_create' => $this->getPrefixedRoute('create'),
            'route_update' => $this->getPrefixedRoute('update'),
        ));
    }

    /**
     * @Route("/create", methods={"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $entity = $this->getEntityProvider()->create();

        $form = $this->createForm($this->crudSettings->getFormAlias(), $entity, array(
            'legend' => $this->getTransKeyFromRoute(),
            'action' => $this->generatePrefixedUrl('create'),
        ));

        if ($this->handleForm($form, $request)) {
            $this->setFlash('btn_admin.flash.created');

            return $this->redirect($this->generatePrefixedUrl('update', array('id' => $entity->getId())));
        }

        return $this->render($this->crudSettings->getCreateTemplate(), array(
            'route_index' => $this->getPrefixedRoute('index'),
            'form'        => $form->createView(),
            'entity'      => $entity,
        ));
    }

    /**
     * @Route("/{id}/update", requirements={"id" = "\d+"}, methods={"GET", "POST"}))
     */
    public function updateAction(Request $request, $id)
    {
        $entity = $this->findEntityOr404($this->getEntityProvider()->getClass(), $id);

        $updateActionUrl = $this->generatePrefixedUrl('update', array('id' => $id));

        $form = $this->createForm($this->crudSettings->getFormAlias(), $entity, array(
            'legend' => $this->getTransKeyFromRoute(),
            'action' => $updateActionUrl,
        ));

        if ($this->handleForm($form, $request)) {
            $this->setFlash('btn_admin.flash.updated');

            return $this->redirect($updateActionUrl);
        }

        return $this->render($this->crudSettings->getUpdateTemplate(), array(
            'route_index'  => $this->getPrefixedRoute('index'),
            'route_delete' => $this->getPrefixedRoute('delete'),
            'form'         => $form->createView(),
            'entity'       => $entity,
        ));
    }

    /**
     * @Route("/{id}/delete/{csrf_token}", requirements={"id" = "\d+"}, methods={"GET"})
     */
    public function deleteAction(Request $request, $id, $csrf_token)
    {
        $this->validateCsrfTokenOrThrowException($this->getRoutePrefix() . '_delete', $csrf_token);

        $entityProvider = $this->getEntityProvider();
        $entity         = $this->findEntityOr404($entityProvider->getClass(), $id);

        $entityProvider->delete($entity);

        $this->setFlash('btn_admin.flash.deleted');

        return $this->redirect($this->generatePrefixedUrl('index'));
    }
}
