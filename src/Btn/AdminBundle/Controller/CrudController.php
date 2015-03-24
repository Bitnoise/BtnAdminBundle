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
    public function indexAction(Request $request)
    {
        if ($this->hasFilter()) {
            $filter     = $this->getFilter();
            $filterForm = $filter->createForm(null, array(
                'action' => $this->generatePrefixedUrl('index'),
            ));
            $filter->applyFilters();
            $entities   = $filter->getQuery();
        } else {
            $repo       = $this->getEntityProvider()->getRepository();
            $entities   = method_exists($repo, 'findAllForCrudIndex') ? $repo->findAllForCrudIndex() : $repo->findAll();
            $filterForm = null;
        }

        return $this->render($this->crudSettings->getIndexTemplate(), array_merge(
            $this->getIndexBaseParameters(),
            array(
                'filter_form' => $filterForm ? $filterForm->createView() : null,
                'pagination'  => $this->paginate($entities),
            )
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
    public function deleteAction(Request $request, $id, $csrf_token)
    {
        $this->validateCsrfTokenOrThrowException($this->getRoutePrefix().'_delete', $csrf_token);

        $entityProvider = $this->getEntityProvider();
        $entity         = $this->findEntityOr404($entityProvider->getClass(), $id);

        $this->get('event_dispatcher')->dispatch(CrudEvents::ENTITY_DELETED, new CrudEvent($entity));

        $entityProvider->delete($entity);

        $this->setFlash('btn_admin.flash.deleted');

        return $this->redirect($this->generatePrefixedUrl('index'));
    }

    /**
     *
     */
    protected function getIndexBaseParameters()
    {
        return array(
            'col_act_class' => $this->container->getParameter('btn_admin.list.col_act_class'),
            'list_header'   => $this->getTransKeyFromRoute(),
            'route_prefix'  => $this->getRoutePrefix(),
            'route_index'   => $this->getPrefixedRoute('index'),
            'route_new'     => $this->getPrefixedRoute('new'),
            'route_edit'    => $this->getPrefixedRoute('edit'),
        );
    }
}
