<?php

namespace Utils\Tests;

use Utils\Optional;
use PHPUnit\Framework\TestCase;

class OptionalArrayTest extends TestCase
{

    /**
     * @test
     */
    public function ifArrayHasAttributeReturnValue() {
        $array = [
            'test' => 1
        ];
        $this->assertEquals(1, Optional::of($array)['test']->get());
    }

    /**
     * @test
     */
    public function ifArrayHasNotAttributeReturnNull() {
        $array = [];
        $this->assertEquals(null, Optional::of($array)[5]->get());
    }

    /**
     * @test
     */
    public function ifAttributeHasNotTheAttributeReturnElseValue() {
        $array = [];
        $this->assertEquals(10, Optional::of($array)['test']->orElseGet(10));
    }

    /**
     * @test
     */
    public function ifArrayHasAttributeReturnNotElseValue() {
        $array = [
            'test' => 5
        ];
        $this->assertEquals(5, Optional::of($array)['test']->orElseGet(10));
    }

    /**
     * @test
     */
    public function chainingOfAttributesReturnValue() {
        $array = [
            'test' => [
                'test1' => [
                    'test2' => 10
                ]
            ]
        ];
        $this->assertEquals(10, Optional::of($array)['test']['test1']['test2']->get());
    }

    /**
     * @test
     */
    public function ifChainIsBrokenReturnNull() {
        $array = [
            'test' => [
                'test2' => 10
            ]
        ];
        $this->assertEquals(null, Optional::of($array)['test']['test1']['test2']->get());
    }
}