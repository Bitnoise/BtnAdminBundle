<?php

namespace Btn\AdminBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;

class MenuBuilder
{
    private $factory;

    /** @var \Symfony\Component\Translation\TranslatorInterface $translator */
    private $translator;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, TranslatorInterface $translator)
    {
        $this->factory    = $factory;
        $this->translator = $translator;
    }

    /**
     *
     */
    public function createMenu(Request $request, $name, $route, array $routeParameters = array(), array $children = array())
    {
        $attributes = array(
            'label' => $this->translator->trans($name),
            'route' => $route,
        );
        if ($name == 'top_menu') {
            $attributes ['childrenAttributes'] = array(
                'class' => 'nav navbar-nav'
            );
        } elseif (!empty($children)) {
            $attributes ['attributes'] = array(
                'class' => 'dropdown'
            );
            $attributes ['childrenAttributes'] = array(
                'class' => 'dropdown-menu',
                'role'  => 'menu'
            );
            $attributes ['linkAttributes'] = array(
                'class'       => 'dropdown-toggle',
                'data-toggle' => 'dropdown',
            );
        }
        $menu = $this->factory->createItem($name, $attributes);

        foreach ($children as $child) {
            $menu->addChild($child);
        }

        return $menu;
    }

}
