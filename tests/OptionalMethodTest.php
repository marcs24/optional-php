<?php

namespace Utils\Tests;

use Utils\Optional;
use PHPUnit\Framework\TestCase;

class OptionalMethodTest extends TestCase
{
    /**
     * @test
     */
    public function ifChainWasNotBrokenReturnValue() {
        $objectA = new class {
            public function exampleMethodA() {
                $objectB = new class {
                    public function exampleMethodB() {
                        return 5;
                    }
                };
                return $objectB;
            }
        };
        $this->assertEquals(5, Optional::of($objectA)->exampleMethodA()->exampleMethodB()->get());
    }

    /**
     * @test
     */
    public function ifChainIsBrokenReturnNull() {
        $objectA = new class {
            public function exampleMethodA() {
                return new \stdClass();
            }
        };
        $this->assertEquals(null, Optional::of($objectA)->exampleMethodA()->exampleMethodB()->get());
    }

    /**
     * @test
     */
    public function ifObjectHasMethodReturnNotElseValue() {
        $objectA = new class {
            public function exampleMethodA() {
                return 11;
            }
        };
        $this->assertEquals(11, Optional::of($objectA)->exampleMethodA()->orElseGet(43));
    }

    /**
     * @test
     */
    public function ifObjectHasNotMethodReturnElseValue() {
        $objectA = new \stdClass();
        $this->assertEquals(43, Optional::of($objectA)->exampleMethodA()->orElseGet(43));
    }
}
