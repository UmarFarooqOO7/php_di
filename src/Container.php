<?php

namespace App;

use ReflectionClass;
use Exception;

class Container
{
    private array $bindings = [];

    public function bind(string $key, callable|string $resolver)
    {
        echo "Binding {$key} to {$resolver}<br>";
        $this->bindings[$key] = $resolver;
    }

    public function resolve(string $key)
    {
        echo "Resolving {$key}<br>";
        if (isset($this->bindings[$key])) {
            echo "Using explicit binding for {$key}<br>";
            $resolver = $this->bindings[$key];

            echo "Resolver: " . (is_callable($resolver) ? 'Closure' : $resolver) . "<br>";
            return is_callable($resolver) ? $resolver($this) : new $resolver();
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
