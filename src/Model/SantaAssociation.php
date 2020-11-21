<?php


namespace Model;


/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class SantaAssociation
{
    /** @var Participant */
    private $from;

    /** @var Participant */
    private $to;

    public function __construct(Participant $from, Participant $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return Participant
     */
    public function from(): Participant
    {
        return $this->from;
    }

    /**
     * @return Participant
     */
    public function to(): Participant
    {
        return $this->to;
    }
}