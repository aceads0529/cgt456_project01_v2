<?php

class Foo
{
    static $a;

    public function __construct()
    {
        self::$a = 'FOO';
    }
}

class Bar extends Foo
{
    static $a;

    public function __construct()
    {
        parent::__construct();
        self::$a = 'BAR';
    }
}

$foo = new Foo();
$bar = new Bar();

echo Foo::$a;
echo Bar::$a;