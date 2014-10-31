<?php

namespace Btn\AdminBundle\Model;

use Gedmo\Sortable\Entity\Repository\SortableRepository;

class AbstractSortableRepository extends SortableRepository
{
    public function updatePositions($input, $offset = 0)
    {
        foreach ($input as $key => $item) {
            if (is_numeric($item)) {
                $input[$key] = array('id' => $item);
            }
        }

        $position = $offset;

        foreach ($input as $item) {
            $entity = $this->findOneById($item['id']);
            if (!$entity) {
                throw new \Exception(sprintf('Entity with id %s was not found', $item['id']));
            }
            $entity->setPosition($position++);
        }
    }
}
