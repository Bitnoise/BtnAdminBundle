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
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
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
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        return $this->createAction($request);
    }

    /**
     * @Route("/create", methods={"POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function createAction(Request $request)
    {
        $entityProvider = $this->getEntityProvider();
        $entity = $entityProvider->create();

        $form = $this->createForm($this->crudSettings->getFormName(), $entity, array(
            'legend' => $this->getTransKeyFromRoute(),
            'action' => $this->generatePrefixedUrl('create'),
        ));

        if (($result = $this->handleForm($form, $request))) {
            if (is_object($result) && $entityProvider->supports($result)) {
                $entity = $result;
            }

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
     * @Route("/{id}/edit", methods={"GET"}))
     * @param Request $request
     * @param integer $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        return $this->updateAction($request, $id);
    }

    /**
     * @Route("/{id}/update", methods={"POST"}))
     * @param Request $request
     * @param integer $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function updateAction(Request $request, $id)
    {
        $entityProvider = $this->getEntityProvider();
        $entity = $entityProvider->find($id);
        if (!$entity) {
            return $this->createNotFoundException(
                sprintf('The %s entity with %s was not found.', $entityProvider->getClass(), $id)
            );
        }

        $form = $this->createForm($this->crudSettings->getFormName(), $entity, array(
            'legend' => $this->getTransKeyFromRoute(),
            'action' => $this->generatePrefixedUrl('update', array('id' => $id)),
        ));

        if (($result = $this->handleForm($form, $request))) {
            if (is_object($result) && $entityProvider->supports($result)) {
                $entity = $result;
            }

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
     * @Route("/{id}/delete/{csrf_token}", methods={"GET"})
     * @param Request $request
     * @param integer $id
     * @param string  $csrf_token
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
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
            'route_delete'  => $this->getPrefixedRoute('delete'),
        );
    }
}
