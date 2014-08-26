<?php

namespace TripSorter\Definition;

/**
 * Abstract class Boarding Card
 *
 * @author Pawel Wilk <pwilkmielno@gmail.com>
 *
 */
abstract class BoardingCard
{
    protected $departure;
    protected $arrival;

    /**
     * Return string representation of Boarding Card
     *
     * @param BoardingCard $lastCard
     *
     * @return string
     */
    abstract public function getDescription(BoardingCard $lastCard = null);

    /**
     * Constructor
     *
     * @param string $departure
     * @param string $arrival
     */
    public function __construct($departure, $arrival)
    {
        $this->departure = $departure;
        $this->arrival = $arrival;
    }

    /**
     * Method return departure station
     *
     * @return string
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * Method set departure station
     *
     * @param string $departure
     *
     * @return \TripSorter\Definition\BoardingCard
     */
    public function setDeparture($departure)
    {
        $this->departure = $departure;

        return $this;
    }

    /**
     * Method returns arrival station
     *
     * @return string
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    /**
     * Method sets arrival station
     *
     * @param string $arrival
     *
     * @return \TripSorter\Definition\BoardingCard
     */
    public function setArrival($arrival)
    {
        $this->arrival = $arrival;

        return $this;
    }

    /**
     * Returns if luggage should be transfered to another travel point if possible
     *
     * @param BoardingCard $card Last trip point
     *
     * @return boolean
     */
    public function isBaggageTransfered(BoardingCard $card)
    {
        return false;
    }
}