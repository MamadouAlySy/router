<?php

namespace MamadouAlySy;

use Closure;

class Route
{
    protected ?string $name;
    protected string $path;
    protected Closure | array | string $action;
    protected array $parameters;

    /**
     * @param string $path
     * @param array|Closure|string $action
     * @param string|null $name
     */
    public function __construct(string $path, Closure|array|string $action, ?string $name = null)
    {
        $this->path = $path;
        $this->action = $action;
        $this->name = $name;
        $this->parameters = [];
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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
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