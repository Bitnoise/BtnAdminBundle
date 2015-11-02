<?php

namespace Btn\AdminBundle\Routing;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UrlGenerator
{
    /** @var \Symfony\Component\Routing\UrlGeneratorInterface */
    protected $router;
    /** @var \Symfony\Component\HttpFoundation\Session\SessionInterface */
    protected $session;

    /**
     * @param UrlGeneratorInterface $router
     */
    public function __construct(UrlGeneratorInterface $router, SessionInterface $session)
    {
        $this->router = $router;
        $this->session = $session;
    }

    /**
     * @param  string|NodeInterface $input
     * @param  bool                 $referenceType
     * @return string
     */
    public function generate($name, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        if (!$parameters) {
            $parameters = $this->session->get('_btn.index_query_state.'.$name, array());
        }

        return $this->router->generate($name, $parameters, $referenceType);
    }
}
