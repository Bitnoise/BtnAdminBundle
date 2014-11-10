<?php

namespace Btn\AdminBundle\Model;

use Gedmo\Sortable\Entity\Repository\SortableRepository;

class AbstractSortableRepository extends SortableRepository
{
    /**
     *
     */
    public function findAllForCrudIndex()
    {
        return $this->findBy(array(), array('position' => 'ASC'));
    }

    /**
     *
     */
    public function disableListener()
    {
        $evm  = $this->getEntityManager()->getEventManager();

        $evm->removeEventSubscriber($this->listener);
    }

    /**
     *
     */
    public function enableListener()
    {
        $evm  = $this->getEntityManager()->getEventManager();

        $evm->addEventSubscriber($this->listener);
    }

    /**
     *
     */
    public function updatePositions($input, $offset = 0)
    {
        foreach ($input as $key => $item) {
            if (is_numeric($item)) {
                $input[$key] = array('id' => $item);
            }
        }

        $position = (int) $offset;

        foreach ($input as $item) {
            $entity = $this->findOneById($item['id']);
            if (!$entity) {
                throw new \Exception(sprintf('Entity with id %s was not found', $item['id']));
            }
            $entity->setPosition($position++);
        }
    }
}
