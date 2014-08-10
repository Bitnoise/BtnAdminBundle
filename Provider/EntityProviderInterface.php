<?php

namespace Btn\AdminBundle\Provider;

interface EntityProviderInterface
{
    public function getEntityManager();
    public function getClass();
    public function getRepository();
    public function create();
    public function supportsClass($class);
    public function delete($entity, $andFlush = true);
}
