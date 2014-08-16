<?php

namespace Btn\AdminBundle\Pager;

use Knp\Component\Pager\Paginator as BasePaginator;

class Paginator extends BasePaginator
{
    /**
     *
     */
    public function getDefaultOptions()
    {
        return $this->defaultOptions;
    }

    /**
     *
     */
    public function getDefaultOption($name)
    {
        return isset($this->defaultOptions[$name]) ? $this->defaultOptions[$name] : null;
    }
}
