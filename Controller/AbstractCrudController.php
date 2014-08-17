<?php

namespace Btn\AdminBundle\Controller;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Btn\AdminBundle\Annotation\CrudSettings;

/**
 *
 */
abstract class AbstractCrudController extends AbstractControlController
{
    /** $var \Btn\AdminBundle\Annotation\CrudSettings $crudSettings */
    protected $crudSettings;

    /**
     * Method to inject crud controller annotation
     */
    public function setCrudSettings(CrudSettings $crudSettings)
    {
        $this->crudSettings = $crudSettings;
    }

    /**
     *
     */
    public function getRoutePrefix()
    {
        return $this->crudSettings->getRoutePrefix();
    }

    /**
     *
     */
    public function getPrefixedRoute($route)
    {
        return $this->getRoutePrefix() . '_' . $route;
    }

    /**
     * Generate route with route prefix for crud controller
     */
    public function generatePrefixedUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->generateUrl($this->getPrefixedRoute($route), $parameters, $referenceType);
    }

    /**
     *
     */
    public function getTransKeyFromRoute()
    {
        $route = $this->getRequest()->attributes->get('_route');

        return preg_replace('~^(btn\_[a-z0-9]+)\_~', '$1.', $route);
    }
}
