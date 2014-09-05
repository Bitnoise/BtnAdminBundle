<?php

namespace Btn\AdminBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;

abstract class AbstractMenuBuilder
{
    /** @var \Knp\Menu\FactoryInterface */
    protected $factory;

    /** @var \Symfony\Component\Translation\TranslatorInterface $translator */
    protected $translator;

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
    public function createMenu(Request $request, $name, $route, array $routeParams = array(), array $children = array())
    {
        $attributes = array(
            'label'           => $this->translator->trans($name),
            'route'           => $route,
            'routeParameters' => $routeParams,
        );

        $menu = $this->factory->createItem($name, $attributes);

        foreach ($children as $child) {
            $this->addChild($request, $menu, $child);
        }

        return $menu;
    }

    /**
     *
     */
    protected function addChild(Request $request, ItemInterface $menu, $child)
    {
        if ($child instanceof ItemInterface) {
            $menu->addChild($child);
        } else {
            throw new \Exception(sprinf('Invalid child for addChild() in "%s" ', __CLASS__));
        }
    }
}
