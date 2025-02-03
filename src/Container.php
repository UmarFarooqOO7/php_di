<?php

namespace App;

use ReflectionClass;
use Exception;

class Container
{
    private array $bindings = [];
    private array $instances = [];

    public function bind(string $key, callable|string $resolver, bool $singleton = false)
    {
        $this->bindings[$key] = [
            'resolver' => $resolver,
            'singleton' => $singleton
        ];
    }

    public function singleton(string $key, callable|string $resolver)
    {
        // use bind method with $singleton = true
        $this->bind($key, $resolver, true);
    }

    public function resolve(string $key)
    {
        // Return cached instance if it exists
        if (isset($this->instances[$key])) {
            echo "Returning cached instance for {$key}<br>";
            return $this->instances[$key];
        }

        echo "Resolving {$key}<br>";
        if (isset($this->bindings[$key])) {
            echo "Using explicit binding for {$key}<br>";
            $binding = $this->bindings[$key];
            $resolver = $binding['resolver'];

            echo "Resolver: " . (is_callable($resolver) ? 'Closure' : $resolver) . "<br>";
            $instance = is_callable($resolver) ? $resolver($this) : new $resolver();

            // Cache instance if it's a singleton
            if ($binding['singleton']) {
                echo "Caching singleton instance for {$key}<br>";
                $this->instances[$key] = $instance;
            }

            return $instance;
        }

        if (class_exists($key)) {
            echo "Auto-resolving {$key}<br>";
            return $this->autoResolve($key);
        }

        throw new Exception("Cannot resolve {$key}");
    }

    private function autoResolve(string $class)
    {
        echo "autoResolve {$class}<br>";
        $reflection = new ReflectionClass($class);

        $constructor = $reflection->getConstructor();
        if (!$constructor) {
            echo "No constructor found for {$class}<br>";
            return new $class();
        }

        $dependencies = [];
        foreach ($constructor->getParameters() as $param) {
            echo "Resolving constructor parameter {$param->getName()}<br>";
            $paramType = $param->getType();

            if ($paramType && !$paramType->isBuiltin()) {
                echo "Resolving dependency {$paramType->getName()}<br>";
                $dependencies[] = $this->resolve($paramType->getName());
            } else {
                throw new Exception("Cannot resolve dependency {$param->getName()}");
            }
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}
