<?php

namespace Btn\AdminBundle\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Btn\AdminBundle\Routing\UrlGenerator;

class PathExtension extends \Twig_Extension
{
    /** @var \Btn\AdminBundle\Routing\UrlGenerator */
    protected $urlGenerator;

    /**
     * @param UrlGenerator $urlGenerator
     */
    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     *
     */
    public function getFunctions()
    {
        return array(
            'btn_admin_path' => new \Twig_Function_Method($this, 'generate'),
        );
    }

    /**
     *
     */
    public function generate($name, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->urlGenerator->generate($name, $parameters, $referenceType);
    }

    /**
     *
     */
    public function getName()
    {
        return 'btn_admin.extension.path';
    }
}
