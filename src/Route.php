<?php

declare(strict_types=1);

namespace MamadouAlySy;

use Closure;
use MamadouAlySy\Exceptions\RouteCallException;

class Route
{
    protected ?string $name;
    protected string $path;
    protected Closure | array $callable;
    protected array $parameters;
    protected array $withParameters;

    public function __construct(string $path, Closure | array $callable, ?string $name = null)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
        $this->name = $name;
        $this->parameters = [];
    }

    /**
     * @return string te route path
     */
    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getCallable(): Closure | array
    {
        return $this->callable;
    }

    public function setCallable(Closure | array $callable): void
    {
        $this->callable = $callable;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    protected function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    public function with(string $key, string $regex): self
    {
        $this->withParameters[$key] = str_replace('(', '(?:', $regex);
        return $this;
    }

    public function match(string $url): bool
    {
        $url = trim($url, '/');
        $regex = preg_replace_callback("#:(\w+)#", [$this, 'paramMatch'], $this->getPath());
        if (preg_match("#^$regex$#", $url, $matches)) {
            array_shift($matches);
            $this->setParameters($matches);
            return true;
        }
        return false;
    }

    protected function paramMatch(array $matches)
    {
        if (isset($this->withParameters[$matches[1]])) {
            return '(' . $this->withParameters[$matches[1]] . ')';
        }
        return "([^/]+)";
    }

    public function generateUri(array $parameters = []): string
    {
        $path = $this->getPath();
        foreach ($parameters as $key => $value) {
            $path = str_replace(":$key", strval($value), $path);
        }
        return '/' . trim($path, '/');
    }

    public function call()
    {
        $callable = $this->getCallable();
        if (is_array($callable) && count($callable) === 2) {
            list($controllerName, $actionName) = $callable;
            if (class_exists($controllerName)) {
                $controllerObject = new $controllerName();
                if (is_callable([$controllerObject, $actionName])) {
                    return call_user_func_array([$controllerObject, $actionName], $this->getParameters());
                }
                throw new RouteCallException("Unable to call \"$controllerName::$actionName\" make sure that it exists an it's callable.");
            }
            throw new RouteCallException("class \"$controllerName\" doest not exists.");
        }
        return call_user_func_array($callable, $this->getParameters());
    }
}
