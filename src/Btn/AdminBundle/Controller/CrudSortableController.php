<?php

namespace Btn\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Btn\AdminBundle\Model\AbstractSortableRepository;

class CrudSortableController extends CrudController
{
    /**
     * @Route("/position", methods={"POST"})
     */
    public function positionAction(Request $request)
    {
        $entityProvider = $this->getEntityProvider();
        $repo = $entityProvider->getRepository();

        if (!$repo instanceof AbstractSortableRepository) {
            throw new \Exception(
                'This action is only avalible for repository that extends '.
                'Btn\\AdminBundle\\Model\\AbstractSortableRepository'
            );
        }

        $data = json_decode($request->getContent(), true);

        $repo->updatePositions($data[0]);
        $repo->disableListener();
        $this->get('doctrine.orm.entity_manager')->flush();
        $repo->enableListener();

        return $this->renderJson();
    }
}
