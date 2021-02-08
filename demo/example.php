<?php

use PhpSwaggerAutoTester\Schema;
use PhpSwaggerAutoTester\Tester;

$schema = new Schema();
$schema->loadFromJson(__DIR__ . '/swagger.json');

$tester = new Tester();
$tester->usingSchema($schema)->runTests();
