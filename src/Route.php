<?php

namespace MamadouAlySy;

use Closure;

class Route
{
    protected string $method;
    protected string $path;
    protected Closure | array | string $action;
    protected array $parameters;

    /**
     * @param string $method
     * @param string $path
     * @param array|Closure|string $action
     */
    public function __construct(string $method, string $path, Closure|array|string $action)
    {
        $this->method = $method;
        $this->path = $path;
        $this->action = $action;
        $this->parameters = [];
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return strtolower($this->method);
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return array|Closure|string
     */
    public function getAction(): Closure|array|string
    {
        return $this->action;
    }

    /**
     * @param array|Closure|string $action
     */
    public function setAction(Closure|array|string $action): void
    {
        $this->action = $action;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }
}