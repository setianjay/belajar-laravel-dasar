<?php

namespace Tests\Feature;

use App\Data\ {Foo, Bar, Dor, Dar};
use App\Services\HalloService;
use App\Services\HalloServiceImpl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DependencyInjectionTest extends TestCase
{
   /**
    * Basic dependency injection.
    *
    * @return void
    */
    public function test_manual_dependency_injection(){
        $foo = new Foo();
        $bar = new Bar($foo);

        self::assertEquals("Foo and Bar", $bar->bar());
    }

    /**
    * Dependency injection with _bind_ as Service Container. If we use _bind_ to handle creating object, object will always be created new.
    *
    * @return void
    */
    public function test_dependency_injection_bind_make_as_service_container(){
        $this->app->bind(Foo::class);

        //use bind with case object have constructor
        $this->app->bind(Bar::class, function($app){
            return new Bar($app->make(Foo::class));
        });
        
        $foo = $this->app->make(Foo::class);
        $bar = $this->app->make(Bar::class);

        self::assertNotSame($foo, $bar->getFoo());
    }

    /**
    * Dependency injection with _singleton_ as Service Container. If we use _singleton_ to handle creating object, object will return same instance.
    *
    * @return void
    */
    public function test_dependency_injection_with_singleton_as_service_container(){
        $this->app->singleton(Foo::class);
        
        //use singleton with case object have constructor
        $this->app->singleton(Bar::class, function($app){
            return new Bar($app->make(Foo::class));
        });

        $foo1 = $this->app->make(Foo::class); //if not yet provide in Service Container, create the object new Foo()
        $foo2 = $this->app->make(Foo::class); //if the dependency is exist, return the same instance

        $bar1 = $this->app->make(Bar::class); //if not yet provide in Service Container, create the object new Foo()
        $bar2 = $this->app->make(Bar::class); //if the dependency is exist, return the same instance
        
        self::assertSame($foo1, $foo2); //success, because foo1 and foo2 have same reference object
        self::assertSame($bar1, $bar2); //success, because bar1 and bar 2 have same reference object
        self::assertSame($foo1, $bar1->getFoo()); //success, because foo1 and other foo in bar1 object have same reference
        self::assertSame($foo2, $bar2->getFoo()); //success, because foo2 and other foo in bar2 object have same reference
    }

    /**
    * Dependency injection only with _make_. By default if Service Container not provide the dependency, laravel create the dependency by it self and _make_ will always create a new object.
    *
    * @return void
    */
    public function test_dependency_injection_only_with_make(){
        // $dor = $this->app->make(Dor::class); // error, laravel doesn't provide the dependency(Dar) because the dependency have constructor so laravel doesn't provide it automatically.
        
        $bar = $this->app->make(Bar::class); // works, laravel will create the dependecy(Foo) it self because the dependency not have constuctor so laravel will create it self.
        self::assertEquals("Foo and Bar", $bar->bar());
    }

     /**
    * Dependency injection with case provide a interfaces with _bind_.
    *
    * @return void
    */
    public function test_dependency_injection_to_provide_interfaces_with_bind(){
        $this->app->bind(HalloService::class, HalloServiceImpl::class);
        
        $hallo1 = $this->app->make(HalloService::class);
        $hallo2 = $this->app->make(HalloService::class);

        self::assertEquals("Hallo Hari", $hallo1->sayHello("Hari"));
        self::assertEquals("Hallo Hari", $hallo2->sayHello("Hari"));

        self::assertNotSame($hallo1, $hallo2);
    }

     /**
    * Dependency injection with case provide a interfaces with _singleton_.
    *
    * @return void
    */
    public function test_dependency_injection_to_provide_interfaces_with_singleton(){
        $this->app->singleton(HalloService::class, HalloServiceImpl::class);
        
        $hallo1 = $this->app->make(HalloService::class);
        $hallo2 = $this->app->make(HalloService::class);

        self::assertEquals("Hallo Hari", $hallo1->sayHello("Hari"));
        self::assertEquals("Hallo Hari", $hallo2->sayHello("Hari"));

        self::assertSame($hallo1, $hallo2);
    }
}
