<?php

namespace App\Tests\Support;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

trait Kernel
{
    /**
     * @var KernelInterface
     */
    private static $kernel;

    /**
     * @var ContainerInterface
     */
    private static $container;

    /**
     * @beforeClass
     */
    public static function bootKernel(): void
    {
        $kernelClass = $_ENV['KERNEL_CLASS'];
        $env = $_ENV['APP_ENV'] ?: 'test';
        $debug = $_ENV['APP_DEBUG'] ?: true;

        self::$kernel = new $kernelClass($env, $debug);
        self::$kernel->boot();

        self::$container = self::$kernel->getContainer();
    }

    /**
     * @afterClass
     */
    public static function shutdownKernel(): void
    {
        static::$kernel->shutdown();
        
        static::$kernel = null;
        static::$container = null;
    }
}
