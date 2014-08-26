<?php

namespace TripSorter\Cards;

use TripSorter\Definition\BoardingCard;

/**
 * Class represents boarding card for vehicle(train/bus/taxi/etc)
 *
 * @author Pawel Wilk <pwilkmielno@gmail.com>
 *
 */
class VehicleCard extends BoardingCard
{
    protected $name;
    protected $seat;

    /**
     * Constructor
     *
     * @param string $departure Name of departure place
     * @param string $arrival   Name of arrival place
     * @param string $name      Name of vehicle transportation
     * @param mixed  $seat      Null if seat is not assigned, string if assigned
     */
    public function __construct($departure, $arrival, $name, $seat = null)
    {
        parent::__construct($departure, $arrival);

        $this->name = $name;
        $this->seat = $seat;
    }


    /**
     * Get $name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set $name
     *
     * @param string $name
     *
     * @return \TripSorter\Cards\VehicleCard
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Method return seat assigment
     *
     * @return mixed Null when seat is not assigned, string when assigned
     */
    public function getSeat()
    {
        return $this->seat;
    }

    /**
     * Method set seat assigment
     *
     * @param mixed $seat Null when seat is not assigned, string when assigned
     *
     * @return \TripSorter\Cards\VehicleCard
     */
    public function setSeat($seat)
    {
        $this->seat = $seat;

        return $this;
    }

    /**
     * Text representation of vehicle travel
     *
     * @param BoardingCard $lastCard
     *
     * @return string
     */
    public function getDescription(BoardingCard $lastCard = null)
    {
        $output = sprintf('Take %s from %s to %s.', $this->getName(), $this->getDeparture(), $this->getArrival());
        if ($this->getSeat() === null) {
            $output .= ' No seat assignment.';
        } else {
            $output .= sprintf(' Sit in seat %s.', $this->getSeat());
        }

        return $output;
    }

}