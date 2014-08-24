<?php

namespace Btn\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Btn\AdminBundle\Event\CrudEvent;
use Btn\AdminBundle\CrudEvents;

class CrudController extends AbstractCrudController
{
    /**
     * @Route("/", methods={"GET", "POST"})
     */
    public function indexAction()
    {
        $repo     = $this->getEntityProvider()->getRepository();
        $entities = $repo->findAll();

        return $this->render($this->crudSettings->getIndexTemplate(), array(
            'list_header'  => $this->getTransKeyFromRoute(),
            'pagination'   => $this->paginate($entities),
            'route_index'  => $this->getPrefixedRoute('index'),
            'route_new'    => $this->getPrefixedRoute('new'),
            'route_edit'   => $this->getPrefixedRoute('edit'),
        ));
    }

    /**
     * @Route("/new", methods={"GET"})
     */
    public function newAction(Request $request)
    {
        return $this->createAction($request);
    }

    /**
     * @Route("/create", methods={"POST"})
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

            $this->get('event_dispatcher')->dispatch(CrudEvents::ENTITY_CREATED, new CrudEvent($entity));

            return $this->redirect($this->generatePrefixedUrl('edit', array('id' => $entity->getId())));
        }

        return $this->render($this->crudSettings->getCreateTemplate(), array(
            'route_index' => $this->getPrefixedRoute('index'),
            'form'        => $form->createView(),
            'entity'      => $entity,
        ));
    }

    /**
     * @Route("/{id}/edit", requirements={"id" = "\d+"}, methods={"GET"}))
     */
    public function editAction(Request $request, $id)
    {
        return $this->updateAction($request, $id);
    }

    /**
     * @Route("/{id}/update", requirements={"id" = "\d+"}, methods={"POST"}))
     */
    public function updateAction(Request $request, $id)
    {
        $entity = $this->findEntityOr404($this->getEntityProvider()->getClass(), $id);

        $form = $this->createForm($this->crudSettings->getFormAlias(), $entity, array(
            'legend' => $this->getTransKeyFromRoute(),
            'action' => $this->generatePrefixedUrl('update', array('id' => $id)),
        ));

        if ($this->handleForm($form, $request)) {
            $this->setFlash('btn_admin.flash.updated');

            $this->get('event_dispatcher')->dispatch(CrudEvents::ENTITY_UPDATED, new CrudEvent($entity));

            return $this->redirect($this->generatePrefixedUrl('edit', array('id' => $id)));
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
    public function deleteAction($id, $csrf_token)
    {
        $this->validateCsrfTokenOrThrowException($this->getRoutePrefix().'_delete', $csrf_token);

        $entityProvider = $this->getEntityProvider();
        $entity         = $this->findEntityOr404($entityProvider->getClass(), $id);

        $this->get('event_dispatcher')->dispatch(CrudEvents::ENTITY_DELETED, new CrudEvent($entity));

        $entityProvider->delete($entity);

        $this->setFlash('btn_admin.flash.deleted');

        return $this->redirect($this->generatePrefixedUrl('index'));
    }
}
