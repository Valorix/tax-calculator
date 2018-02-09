<?php

/**
 * Class TaxCalculator
 */
class TaxCalculator
{
    /**
     * @var array
     */
    private $edges = array();

    /**
     * Calculate the tax
     *
     * @param float $value
     * @return float
     */
    public function getTax(float $value): float
    {
        if (!empty($this->edges)) {
            if ($value > 0) {
                return $this->calculateTax($value);
            } else {
                throw new InvalidArgumentException("$value must be greater than 0");
            }
        } else {
            throw new InvalidArgumentException('No edge set');
        }
    }

    /**
     * @return array
     */
    public function getEdges(): array
    {
        return $this->edges;
    }

    /**
     * @param Edge $edge
     * @return $this
     */
    public function addEdge(Edge $edge): TaxCalculator
    {
        $this->validateEdge($edge);
        $this->edges[] = $edge;

        return $this;
    }

    /**
     * Check if edge is valid
     *
     * @param Edge $edge
     */
    private function validateEdge(Edge $edge)
    {
        foreach ($this->edges as $thisEdge) {
            if ($edge->getFrom() === $thisEdge->getFrom() && $edge->getTo() === $thisEdge->getTo()) {
                throw new InvalidArgumentException('Edge already added');
            }

            if (
                !is_null($edge->getFrom()) &&
                ($edge->getFrom() >= $thisEdge->getFrom() && $edge->getFrom() < $thisEdge->getTo()
                || ($edge->getTo() > $thisEdge->getFrom() && $edge->getTo() <= $thisEdge->getTo()))
            ) {
                throw new InvalidArgumentException("Edge conflict between [{$edge->getFrom()}, {$edge->getTo()}] and existed edge [{$thisEdge->getFrom()}, {$thisEdge->getTo()}]");
            }
        }
    }

    /**
     * Calculate tax according to edges
     *
     * @param float $value
     * @return float
     */
    private function calculateTax(float $value): float
    {
        $tax = 0;

        foreach ($this->edges as $edge) {
            if (!is_null($edge->getFrom())) {
                if ($value > $edge->getTo() || ($value >= $edge->getFrom() && $value <= $edge->getTo())) {
                    $tax += ($edge->getTax() / 100) * ($value < $edge->getTo() ? $value : $edge->getTo() - $edge->getFrom());
                }
            } elseif ($value > $edge->getTo()) {
                $tax += ($edge->getTax() / 100) * ($value - $edge->getTo());
            }
        }

        return $tax;
    }

}
