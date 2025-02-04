<?php

namespace Tests\Container;

use PHPUnit\Framework\TestCase;
use App\Container;
use App\Container\Exceptions\BindingResolutionException;

// Test interfaces and classes
interface TestInterface {}
class TestImplementation implements TestInterface {}
class TestDependency {}
class TestService {
    public TestDependency $dependency;
    
    public function __construct(TestDependency $dependency) {
        $this->dependency = $dependency;
    }
}

class ContainerTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        $this->container = new Container();
    }

    public function testCanBindAndResolveClass(): void
    {
        $this->container->bind(TestImplementation::class, TestImplementation::class);
        
        $instance = $this->container->resolve(TestImplementation::class);
        
        $this->assertInstanceOf(TestImplementation::class, $instance);
    }

    public function testCanBindInterfaceToImplementation(): void
    {
        $this->container->bind(TestInterface::class, TestImplementation::class);
        
        $instance = $this->container->resolve(TestInterface::class);
        
        $this->assertInstanceOf(TestImplementation::class, $instance);
    }

    public function testCanBindSingleton(): void
    {
        $this->container->singleton(TestImplementation::class, function() {
            return new TestImplementation();
        });
        
        $instance1 = $this->container->resolve(TestImplementation::class);
        $instance2 = $this->container->resolve(TestImplementation::class);
        
        $this->assertSame($instance1, $instance2);
    }

    public function testCanResolveConstructorDependencies(): void
    {
        $this->container->bind(TestDependency::class, TestDependency::class);
        $this->container->bind(TestService::class, TestService::class);
        
        $instance = $this->container->resolve(TestService::class);
        
        $this->assertInstanceOf(TestService::class, $instance);
        $this->assertInstanceOf(TestDependency::class, $instance->dependency);
    }

    public function testCanBindCallback(): void
    {
        $this->container->bind(TestInterface::class, function() {
            return new TestImplementation();
        });
        
        $instance = $this->container->resolve(TestInterface::class);
        
        $this->assertInstanceOf(TestImplementation::class, $instance);
    }

    public function testCanResolveWithParameters(): void
    {
        $this->container->bind(TestImplementation::class, TestImplementation::class);
        
        $instance = $this->container->resolve(TestImplementation::class);
        
        $this->assertInstanceOf(TestImplementation::class, $instance);
    }
}
