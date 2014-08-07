<?php
namespace Btn\AdminBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class MenuBuilder
{
    private $factory;

    private $translator;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, $translator)
    {
        $this->factory    = $factory;
        $this->translator = $translator;
    }

    public function createTopMenu(Request $request)
    {
        $menu = $this->factory->createItem('top_menu', array('childrenAttributes' => array('class' => 'nav navbar-nav')));
        $menu->addChild($this->translator->trans('btn_control.modules'));

        return $menu;
    }

    public function addToMenu(Request $request, $menu, $name, $route, $module = null)
    {
        if ($module != null) {
            $menu->getChild($module)
                ->setAttribute('class', 'dropdown')
                ->setLinkAttribute('class', 'dropdown-toggle')
                ->setLinkAttribute('data-toggle', 'dropdown')
                ->addChild($this->translator->trans($name), array(
                    'route' => $route
                ));
            $menu->getChild($module)
                ->setChildrenAttribute('class', 'dropdown-menu')
                ->setChildrenAttribute('role', 'menu')
            ;
        } else {
            $menu->addChild($this->translator->trans($name), array(
                'route' => $route
            ));
        }

        return $menu;
    }

}
