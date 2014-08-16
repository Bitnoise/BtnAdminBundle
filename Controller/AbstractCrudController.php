<?php

namespace Btn\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
        $route = $this->getRequest()->attributes->get('_route');

        return substr($route, 0, strrpos($route, '_'));
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
