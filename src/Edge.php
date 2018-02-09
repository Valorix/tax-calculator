<?php
/**
 * Created by PhpStorm.
 * User: mmiatti
 * Date: 09/02/18
 * Time: 12:15
 */
class Edge
{
    /**
     * @var float
     */
    private $from;

    /**
     * @var float
     */
    private $to;

    /**
     * @var float
     */
    private $tax;

    /**
     * Edge constructor.
     * @param mixed float|null $from
     * @param float $to
     * @param float $tax tax to apply
     */
    public function __construct($from, float $to, float $tax)
    {
        $this
            ->setFrom($from)
            ->setTo($to)
            ->setTax($tax)
        ;
    }

    /**
     * @return mixed float|null
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param float|null $from
     * @return $this
     */
    public function setFrom($from)
    {
        if ($this->to) {
            $this->checkValue($from, $this->to);
        }
        $this->from = $from;

        return $this;
    }

    /**
     * @return float
     */
    public function getTo(): float
    {
        return $this->to;
    }

    /**
     * @param float $to
     * @return $this
     */
    public function setTo(float $to)
    {
        if ($this->from) {
            $this->checkValue($this->from, $to);
        }
        $this->to = $to;

        return $this;
    }

    /**
     * @return float
     */
    public function getTax(): float
    {
        return $this->tax;
    }

    /**
     * @param float $tax
     * @return $this
     */
    public function setTax(float $tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Validate $value
     *
     * @param float $from
     * @param float $to
     */
    private function checkValue(float $from, float $to)
    {
        if ($to < $from) {
            throw new InvalidArgumentException("$to is not greater than $from");
        }

    }
}
