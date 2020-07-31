<?php

namespace Utils\Tests;

use Utils\Optional;
use PHPUnit\Framework\TestCase;

class OptionalTest extends TestCase
{
    /**
     * @test
     */
    public function multiOptionalsWillBeCreated() {
        $object = new \stdClass();
        $optionalA = Optional::of($object);
        $optionalB = Optional::of($object);
        $this->assertNotSame($optionalA, $optionalB);
    }

    /**
     * @test
     */
    public function checkErrorsWillBeCreated() {
        $object = new \stdClass();
        $object->b = 5;
        $expectedError = [
            'attribute c does not exist'
        ];
        $this->assertEquals($expectedError, Optional::of($object)->b->c->getErrors());
    }

    /**
     * @test
     */
    public function mutliErrorsWillBeCreated() {
        $object = new \stdClass();
        $expectedError = [
            'attribute b does not exist',
            'attribute c does not exist'
        ];
        $this->assertEquals($expectedError, Optional::of($object)->b->c->getErrors());
    }

    /**
     * @test
     */
    public function errorsCanBePrintedAsString() {
        $object = new \stdClass();
        $this->assertStringContainsString('attribute b does not exist', Optional::of($object)->b->c->printErrors());
        $this->assertStringContainsString('attribute c does not exist', Optional::of($object)->b->c->printErrors());
    }

    /**
     * @test
     */
    public function logPrintErrorsIfNoFunctionIsGiven() {
        $object = new \stdClass();
        $this->expectOutputString('attribute b does not exist');
        Optional::of($object)->b->log();
    }

    /**
     * @test
     */
    public function logCallCallbackIfFunctionIsGiven() {
        $object = new \stdClass();
        $this->expectOutputString('my errors are: attribute b does not exist');
        Optional::of($object)->b->log(function(Optional $optional) {
            echo("my errors are: {$optional->printErrors()}");
        });
    }

    /**
     * @test
     */
    public function chainAfterLogCallCallbackIfFunctionIsGiven() {
        $object = new \stdClass();
        $this->assertEquals(5, Optional::of($object)->b->log(function(Optional $optional) {
            // do nothing
        })->orElseGet(5));
    }
}

