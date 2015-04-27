<?php

namespace Btn\AdminBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Translation\TranslatorInterface;

abstract class AbstractMenuBuilder
{
    /** @var \Knp\Menu\FactoryInterface */
    protected $factory;
    /** @var \Symfony\Component\Translation\TranslatorInterface $translator */
    protected $translator;
    /** @var AuthorizationCheckerInterface $authorizationChecker */
    protected $authorizationChecker;

    /**
     * @param FactoryInterface                   $factory
     * @param TranslatorInterface                $translator
     * @param AuthorizationCheckerInterface|null $authorizationChecker
     */
    public function __construct(
        FactoryInterface $factory,
        TranslatorInterface $translator,
        AuthorizationCheckerInterface $authorizationChecker = null
    ) {
        $this->factory = $factory;
        $this->translator = $translator;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param Request     $request
     * @param string      $name
     * @param string|null $route
     * @param array       $routeParams
     * @param array       $children
     * @param string|null $role
     *
     * @return ItemInterface|void
     *
     * @throws \Exception
     */
    public function createMenu(Request $request, $name, $route, array $routeParams = array(), array $children = array(), $role = null)
    {
        if (null === $route && 0 === count($children)) {
            return;
        }

        if (null !== $role && !$this->authorizationChecker->isGranted($role)) {
            return;
        }

        $attributes = array(
            'label'           => $name,
            'route'           => $route,
            'routeParameters' => $routeParams,
        );

        $menu = $this->factory->createItem($name, $attributes);

        foreach ($children as $child) {
            if (null !== $child) {
                $this->addChild($request, $menu, $child);
            }
        }

        return $menu;
    }

    /**
     * @param Request       $request
     * @param ItemInterface $menu
     * @param ItemInterface $child
     *
     * @throws \Exception
     */
    protected function addChild(Request $request, ItemInterface $menu, $child)
    {
        if ($child instanceof ItemInterface) {
            $menu->addChild($child);
        } else {
            throw new \Exception(sprintf('Invalid child for addChild() in "%s" ', __CLASS__));
        }
    }
}
