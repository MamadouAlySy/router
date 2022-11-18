<?php

declare (strict_types = 1);

namespace MamadouAlySy;

use Closure;
use MamadouAlySy\Exceptions\RouteCallException;

/**
 * @author Mamadou Aly Sy <sy.aly.mamadou@gmail.com>
 */
class Route
{
    private array $withParameters = [];

    public function __construct(
        private string $path,
        private mixed $callable, 
        private ?string $name = null,
        private array $parameters = [])
    {}

    /**
     * @return string the route path
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * @param string $path the new path
     */
    public function setPath( string $path ): void
    {
        $this->path = $path;
    }

    /**
     * @return Closure|array the route callable
     */
    public function getCallable(): Closure | array
    {
        return $this->callable;
    }

    /**
     * @param string $callable the new route callable
     */
    public function setCallable( Closure | array $callable ): void
    {
        $this->callable = $callable;
    }

    /**
     * @return string the new name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name the new name
     */
    public function setName( ?string $name ): void
    {
        $this->name = $name;
    }

    /**
     * @return array the route parameters
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array the route new parameters
     */
    protected function setParameters( array $parameters ): void
    {
        $this->parameters = $parameters;
    }

    /**
     * Adds regular expression constraint for the given key inside the route path
     *
     * @param string $key uri key
     * @param string $regex regular expression for the uri key
     * @return self
     */
    public function with( string $key, string $regex ): self
    {
        $this->withParameters[$key] = str_replace( '(', '(?:', $regex );
        return $this;
    }

    /**
     * Checks if the route path matches the given url
     *
     * @param string $url
     * @return boolean
     */
    public function match( string $url ): bool {
        $url = trim( $url, '/' );
        $regex = preg_replace_callback( "#:(\w+)#", [$this, 'getRegexPattern'], $this->getPath() );

        if ( preg_match( "#^$regex$#", $url, $matches ) ) {
            array_shift( $matches );
            $this->setParameters( $matches );
            return true;
        }

        return false;
    }

    /**
     * Generate the correct regex expression
     * 
     * @param array $matches found Parameters
     * @return string the regex pattern
     */
    protected function getRegexPattern( array $matches ): string
    {

        if ( isset( $this->withParameters[$matches[1]] ) ) {
            return '(' . $this->withParameters[$matches[1]] . ')';
        }

        return "([^/]+)";
    }

    /**
     * @param array $parameters
     * @return string the route uri
     */
    public function generateUri(array $parameters = []): string
    {
        $path = $this->getPath();

        foreach ($parameters as $key => $value) {
            $path = str_replace( ":$key", strval( $value ), $path );
        }

        return '/' . trim( $path, '/' );
    }

}
