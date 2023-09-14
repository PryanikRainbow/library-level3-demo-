<?php

namespace Components;

class InstancesClasses{
    private static array $instances = [];

    public function __construct(array $classes)
    {
        foreach ($classes as $class) {
            self::$instances[$class] = new $class();
        }
    }

    public static function getInstance(string $class)
    {
        if (!array_key_exists($class, self::$instances)) {
            self::$instances[$class] = new $class();
        }

        return self::$instances[$class];
    }
}