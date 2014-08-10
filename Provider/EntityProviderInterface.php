<?php

namespace Btn\AdminBundle\Provider;

interface EntityProviderInterface
{
    public function getEntityManager();
    public function getClassName();
    public function getRepository();
    public function createEntity();
}
