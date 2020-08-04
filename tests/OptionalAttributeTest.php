<?php

namespace Utils\Tests;

use Utils\Optional;
use PHPUnit\Framework\TestCase;

class OptionalAttributeTest extends TestCase
{
    /**
     * @test
     */
    public function ifObjectHasAttributeReturnValue() {
        $object = new \stdClass();
        $object->a = 5;
        $this->assertEquals(5, Optional::of($object)->a->get());
    }

    /**
     * @test
     */
    public function ifObjectHasNotAttributeReturnNull() {
        $object = new \stdClass();
        $this->assertEquals(null, Optional::of($object)->a->get());
    }

    /**
     * @test
     */
    public function ifObjectHasNotTheAttributeReturnElseValue() {
        $object = new \stdClass();
        $this->assertEquals(10, Optional::of($object)->a->orElseGet(10));
    }

    /**
     * @test
     */
    public function ifObjectHasAttributeReturnNotElseValue() {
        $object = new \stdClass();
        $object->a = 5;
        $this->assertEquals(5, Optional::of($object)->a->orElseGet(10));
    }

    /**
     * @test
     */
    public function chainingOfAttributesReturnValue() {
        $objectA = new \stdClass();
        $objectB = new \stdClass();
        $objectC = new \stdClass();

        $objectC->result = 10;
        $objectB->objectC = $objectC;
        $objectA->objectB = $objectB;

        $this->assertEquals(10, Optional::of($objectA)->objectB->objectC->result->get());
    }

    /**
     * @test
     */
    public function ifChainIsBrokenReturnNull() {
        $objectA = new \stdClass();
        $objectB = new \stdClass();
        $objectC = new \stdClass();

        $objectC->result = 10;
        $objectB->objectC = $objectC;
        $objectA->objectB = $objectB;

        $this->assertEquals(null, Optional::of($objectA)->objectD->objectC->result->get());
    }

    /**
     * @test
     */
    public function isEmptyIfValueContainsEmptyArray()
    {
        $objectA = new \stdClass();
        $objectB = new \stdClass();

        $objectB->empytArray = [];
        $objectA->objectB = $objectB;

        $this->assertTrue(Optional::of($objectA)->objectD->emptyArray->isEmpty());
    }

    /**
     * @test
     */
    public function isEmptyIfValueIsNULL()
    {
        $object = new \stdClass();
        $this->assertTrue(Optional::of($object)->something->isEmpty());
    }

    /**
     * @test
     */
    public function isEmptyReturnsFalseIfValueIsGiven()
    {
        $object = new \stdClass();
        $object->result = "hello world";
        $this->assertFalse(Optional::of($object)->result->isEmpty());
    }

    /**
     * @test
     */
    public function isNotEmptyReturnsTrueIfValueIsGiven() {
        $object = new \stdClass();
        $object->result = "hello world";
        $this->assertTrue(Optional::of($object)->result->isNotEmpty());
    }

    /**
     * @test
     */
    public function isNotEmptyReturnsFalseIfValueNotIsGiven() {
        $object = new \stdClass();
        $this->assertFalse(Optional::of($object)->result->isNotEmpty());
    }
}
