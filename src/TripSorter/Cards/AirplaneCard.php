<?php

namespace TripSorter\Cards;

use TripSorter\Definition\BoardingCard;

/**
 * Boarding card for flight
 *
 * @author Pawel Wilk <pwilkmielno@gmail.com>
 *
 */
class AirplaneCard extends BoardingCard
{
    protected $departureGate;
    protected $baggageDrop;
    protected $transferBaggage;
    protected $seat;
    protected $code;

    /**
     * Constructor
     *
     * @param string  $departure       Name of departure palce
     * @param string  $arrival         Name of target place
     * @param string  $code            Flight code
     * @param string  $departureGate   Number/code of departure gate
     * @param string  $seat            Number of seat in plane
     * @param mixed   $baggageDrop     Null when not assigned, string when assigned
     * @param boolean $transferBaggage True if luggage should be transferd to another plane if possible
     */
    public function __construct($departure, $arrival, $code ,$departureGate, $seat = null, $baggageDrop = null, $transferBaggage = true)
    {
        parent::__construct($departure, $arrival);

        $this->departureGate = $departureGate;
        $this->baggageDrop = $baggageDrop;
        $this->transferBaggage = $transferBaggage;
        $this->seat = $seat;
        $this->code = $code;
    }

    /**
     * Method returns assigned departure gate
     *
     * @return string
     */
    public function getDepartureGate()
    {
        return $this->departureGate;
    }

    /**
     * Method set departure gate
     *
     * @param string $departureGate
     *
     * @return \TripSorter\Cards\AirplaneCard
     */
    public function setDepartureGate($departureGate)
    {
        $this->departureGate = $departureGate;

        return $this;
    }

    /**
     * Method returns baggage drop
     *
     * @return mixed Null when baggage drop is not assigned, string when is assigned
     */
    public function getBaggageDrop()
    {
        return $this->baggageDrop;
    }

    /**
     * Set $baggageDrop
     *
     * @param mixed $baggageDrop Null when not assigned, string when assigned
     *
     * @return \TripSorter\Cards\AirplaneCard
     */
    public function setBaggageDrop($baggageDrop)
    {
        $this->baggageDrop = $baggageDrop;

        return $this;
    }

    /**
     * Returns if luggage should be transfered to another travel point if possible
     *
     * @param BoardingCard $lastCard
     *
     * @return boolean
     */
    public function isBaggageTransfered(BoardingCard $lastCard = null)
    {
        if ($lastCard instanceof AirplaneCard) {
            return $lastCard->getTransferBaggage();
        }

        return false;
    }

    /**
     * Sets if luggage should be transfered to another travel point if possible
     *
     * @param boolean $transferBaggage
     *
     * @return \TripSorter\Cards\AirplaneCard
     */
    public function setTransferBaggage($transferBaggage)
    {
        $this->transferBaggage = $transferBaggage;

        return $this;
    }

    /**
     * Return if baggage should be transfered if possible
     *
     * @return boolean
     */
    public function getTransferBaggage()
    {
        return $this->transferBaggage;
    }


    /**
     * Method return seat assigment
     *
     * @return string
     */
    public function getSeat()
    {
        return $this->seat;
    }

    /**
     * Method set seat assigment
     *
     * @param string $seat
     *
     * @return \TripSorter\Cards\Airplane
     */
    public function setSeat($seat)
    {
        $this->seat = $seat;

        return $this;
    }

    /**
     * Return flight code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set flight code
     *
     * @param string $code
     *
     * @return \TripSorter\Cards\AirplaneCard
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Text representation of Airplane travel
     *
     * @param BoardingCard $lastCard
     *
     * @return string
     */
    public function getDescription(BoardingCard $lastCard = null)
    {
        $output = sprintf('From %s, take flight %s to %s. Gate %s, seat %s.', $this->getDeparture(), $this->getCode(), $this->getArrival(), $this->getDepartureGate(), $this->getSeat());

        if ($this->isBaggageTransfered($lastCard)) {
            $output .= sprintf(' Baggage will we automatically transferred from your last leg.');
        } elseif ($this->getBaggageDrop() !== null) {
            $output .= sprintf(' Baggage drop at ticket counter %s.', $this->getBaggageDrop());
        }

        return $output;
    }
}