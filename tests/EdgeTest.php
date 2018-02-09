<?php

use PHPUnit\Framework\TestCase;

class EdgeTest extends TestCase
{
    /**
     * @var Edge
     */
    protected $edge;

    public function testFromLowerThanTo(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Edge(45, 30, 10);
    }
}
