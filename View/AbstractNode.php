<?php

namespace Ubermanu\Xhp\View;

use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\BlockInterface;
use Magento\Framework\View\Element\Context;
use Ubermanu\Xhp\Exception\RenderArrayException;

abstract class AbstractNode extends AbstractBlock
{
    /**
     * @var BlockInterface[]
     */
    protected array $children = [];

    /**
     * @var array
     */
    protected array $attributes = [];

    public function __construct(
        Context $context,
        array $attributes = [],
        array $children = [],
        array $data = []
    ) {
        $this->children = $children;
        $this->attributes = $attributes;
        parent::__construct($context, $data);
    }

    /**
     * @param BlockInterface $child
     * @return $this
     */
    public function appendChild(BlockInterface $child): self
    {
        $this->children[] = $child;
        return $this;
    }

    /**
     * @param BlockInterface $child
     * @return $this
     */
    public function prependChild(BlockInterface $child): self
    {
        array_unshift($this->children, $child);
        return $this;
    }

    /**
     * @return BlockInterface[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @return string
     */
    protected function renderAttributes(): string
    {
        $html = '';
        foreach ($this->attributes as $attr => $val) {
            if (is_array($val) || is_object($val)) {
                $val = json_encode($val);
            } elseif (is_bool($val) && $val) {
                $html .= ' ' . $attr;
                continue;
            }
            $html .= ' ' . $attr . '="' . htmlspecialchars((string)$val) . '"';
        }
        return $html;
    }

    /**
     * @return string
     * @throws RenderArrayException
     */
    protected function renderChildren(): string
    {
        $html = '';
        foreach ($this->children as $child) {
            if (is_array($child)) {
                throw new RenderArrayException(__('Can not render array!'));
            }
            if (is_string($child)) {
                $html .= htmlspecialchars($child);
                continue;
            }
            $html .= (string)$child;
        }
        return $html;
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        return '';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }
}
