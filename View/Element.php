<?php

namespace Ubermanu\Xhp\View;

use Ubermanu\Xhp\Exception\InvalidAttributeNameException;
use Ubermanu\Xhp\Exception\RenderArrayException;

class Element extends AbstractNode
{
    /**
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * @return string
     */
    public function getTagName(): string
    {
        return $this->tagName;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getAttribute(string $name): mixed
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     * @throws InvalidAttributeNameException
     */
    public function setAttribute($name, $value = null): self
    {
        if (!strlen($name) || !preg_match('/^[a-zA-Z]/', $name)) {
            throw new InvalidAttributeNameException(__('Invalid attribute name: "%1"', $name));
        }
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * @param string $attr
     * @return bool
     */
    public function hasAttribute(string $attr): bool
    {
        return isset($this->attributes[$attr]);
    }

    /**
     * @param string $attr
     * @return $this
     */
    public function removeAttribute(string $attr): self
    {
        unset($this->attributes[$attr]);
        return $this;
    }

    /**
     * @return bool
     */
    public function hasAttributes(): bool
    {
        return \count($this->attributes) > 0;
    }

    /**
     * @return string
     * @throws RenderArrayException
     */
    public function _toHtml(): string
    {
        return '<' . $this->getTagName() . $this->renderAttributes() . '>' . $this->renderChildren() . '</' . $this->getTagName() . '>';
    }
}
