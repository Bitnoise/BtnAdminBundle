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

        if (!array_key_exists('newWindow', $options)) {
            if (array_key_exists('uri',$options)) {
                $options['newWindow'] = strpos($options['uri'], 'http') === 0;
            } else {
                $options['newWindow'] = false;
            }
        }

        return $options;
    }

    public function buildItem(ItemInterface $item, array $options)
    {
        $item->setExtra('skipTrans', $options['skipTrans']);
        $item->setExtra('newWindow', $options['newWindow']);
        if ($options['newWindow']) {
            $item->setLinkAttribute('target', '_blank');
        }
    }
}
