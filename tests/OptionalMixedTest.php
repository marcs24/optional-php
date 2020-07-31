<?php

namespace Utils\Tests;

use Utils\Optional;
use PHPUnit\Framework\TestCase;

class OptionalMixedTest extends TestCase
{
    /**
     * @test
     */
    public function ifChainWasNotBrokenReturnValue() {
        $objectA = new class {
            public function exampleMethodA() {
                $objectB = new \stdClass();
                $objectB->result = 5;
                return $objectB;
            }
        };
        $this->assertEquals(5, Optional::of($objectA)->exampleMethodA()->result->get());
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
        $this->assertEquals(null, Optional::of($objectA)->exampleMethodA()->result->get());
    }

    /**
     * @test
     */
    public function ifChainIsBrokenWithArrayReturnNull() {
        $objectA = new class {
            public function exampleMethodA() {
                return new \stdClass();
            }
        };
        $this->assertEquals(null, Optional::of($objectA)->exampleMethodA()->result['keyDoesntExist']->get());
    }
}
