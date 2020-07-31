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
}
