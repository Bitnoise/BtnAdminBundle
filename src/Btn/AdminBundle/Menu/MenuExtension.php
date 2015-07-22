<?php

namespace Btn\AdminBundle\Menu;

use Knp\Menu\Factory\ExtensionInterface;
use Knp\Menu\ItemInterface;

class MenuExtension implements ExtensionInterface
{
    public function buildOptions(array $options = array())
    {
        if (!array_key_exists('skipTrans', $options)) {
            $options['skipTrans'] = false;
        }

        return $options;
    }

    public function buildItem(ItemInterface $item, array $options)
    {
        $item->setExtra('skipTrans', $options['skipTrans']);
    }
}
