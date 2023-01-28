<?php

namespace Ubermanu\Xhp\View;

use Ubermanu\Xhp\Exception\RenderArrayException;

class Fragment extends AbstractNode
{
    /**
     * @return string
     * @throws RenderArrayException
     */
    public function _toHtml(): string
    {
        return $this->renderChildren();
    }
}
