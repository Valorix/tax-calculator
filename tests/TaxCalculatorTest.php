<?php

use PHPUnit\Framework\TestCase;

class TaxCalculatorTest extends TestCase
{
    /**
     * @var TaxCalculator
     */
    private $calculator;

    protected function setUp()
    {
        parent::setUp();
        $this->calculator = new TaxCalculator();
    }

    public function testValueGreaterThanZero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('-58 must be greater than 0');
        $edge = new Edge(0, 60, 15);
        $this->calculator
            ->addEdge($edge)
            ->getTax(-58);
    }

    public function testNoEdgeSet(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('No edge set');
        $this->calculator->getTax(50);
    }

    public function testEdgeAlreadyAdded(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Edge already added');
        $edge = new Edge(0, 60, 15);
        $this->calculator
            ->addEdge($edge)
            ->addEdge($edge);
    }

    public function testEdgeConflictFrom(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Edge conflict');
        $this->calculator
            ->addEdge(new Edge(0, 60, 15))
            ->addEdge(new Edge(50, 60, 15));
    }

    public function testEdgeConflictTo(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Edge conflict');
        $this->calculator
            ->addEdge(new Edge(10, 60, 15))
            ->addEdge(new Edge(0, 20, 15));
    }

    public function testEdgeConflictIn(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Edge conflict');
        $this->calculator
            ->addEdge(new Edge(10, 60, 15))
            ->addEdge(new Edge(20, 40, 15));
    }

    public function testGetTaxOneEdge()
    {
        $edge = new Edge(0, 50, 15);
        $total = $this->calculator
            ->addEdge($edge)
            ->getTax(40);
        $expected = ((15 / 100) * 40);

        $this->assertEquals($expected, $total);
    }

    public function testGetTaxMultiEdge()
    {
        $total = $this->calculator
            ->addEdge(new Edge(0, 50, 15))
            ->addEdge(new Edge(50, 100, 20))
            ->getTax(150);
        $expected = ((15 / 100) * 50);
        $expected += ((20 / 100) * 50);

        $this->assertEquals($expected, $total);
    }

    public function testGetTaxWithSuperiorEdge()
    {
        $total = $this->calculator
            ->addEdge(new Edge(0, 10, 20))
            ->addEdge(new Edge(null, 10, 60))
            ->getTax(100)
        ;
        $expected = ((20 / 100) * 10);
        $expected += ((60 / 100) * (100 - 10));

        $this->assertEquals($expected, $total);
    }

    public function testOutOfEdgeLower()
    {
        $total = $this->calculator
            ->addEdge(new Edge(10, 20, 15))
            ->getTax(5)
        ;

        $this->assertEquals(0, $total);
    }

    public function testOk()
    {
        $total = $this->calculator
            ->addEdge(new Edge(0, 50, 5))
            ->addEdge(new Edge(50, 250, 15))
            ->addEdge(new Edge(250, 500, 25))
            ->addEdge(new Edge(null, 500, 30))
            ->getTax(750)
        ;

        $this->assertEquals(170, $total);
    }
}
