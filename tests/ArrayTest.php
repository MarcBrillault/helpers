<?php

namespace Embryo;

use PHPUnit\Framework\TestCase;

class ArrayTest extends TestCase
{
    public function testArrayDepth()
    {
        $arrays = [
            0 => [],
            1 => ['one dimension'],
            2 => ['two dimensions' => ['']],
            3 => ['three dimensions' => ['other dimensions' => ['']]],
        ];

        foreach ($arrays as $expectedDepth => $array) {
            $this->assertEquals($expectedDepth, arrayDepth($array));
        }
    }
}