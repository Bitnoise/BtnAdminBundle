<?php

namespace Btn\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Btn\AdminBundle\Model\AbstractSortableRepository;

class CrudSortableController extends CrudController
{
    /**
     * @Route("/position", methods={"POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function positionAction(Request $request)
    {
        $entityProvider = $this->getEntityProvider();
        $repo = $entityProvider->getRepository();

        if (!$repo instanceof AbstractSortableRepository) {
            throw new \Exception(
                'This action is only available for repository that extends '.
                'Btn\\AdminBundle\\Model\\AbstractSortableRepository'
            );
        }

        $data = json_decode($request->getContent(), true);

        $items = isset($data['items']) ? $data['items'] : $data[0];
        $offset = isset($data['offset']) ? (int) $data['offset'] : 0;

        $repo->updatePositions($items, $offset);
        $repo->disableListener();
        $this->get('doctrine.orm.entity_manager')->flush();
        $repo->enableListener();

        return $this->renderJson();
    }
}
