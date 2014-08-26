<?php

namespace TripSorter\Collection;

use TripSorter\Definition\BoardingCard;

/**
 * Class responsible for holding collection of boarding cards
 *
 * @author Pawel Wilk <pwilkmielno@gmail.com>
 *
 */
class TripCollection
{
    protected $boardingCards = array();

    /**
     * Constructor
     *
     * @param array $boardingCards Array containing objects of TripSorter\Definition\BoardingCard
     *
     * @throws \UnexpectedValueException
     */
    public function __construct(array $boardingCards = array())
    {
        foreach ($boardingCards as $k => $boardingCard) {
            if (!($boardingCard instanceof BoardingCard))
            {
                throw new \UnexpectedValueException(sprintf('Boarding card %d is not instance of TripSorter\Definition\BoardingCard', $k));
            }
        }

        $this->boardingCards = $boardingCards;
        $this->sort();
    }

    /**
     * Add boarding card to collection
     *
     * @param BoardingCard $boardingCard
     */
    public function add(BoardingCard $boardingCard)
    {
        $this->boardingCards[] = $boardingCard;
    }

    /**
     * Sort boarding classes according departure/arrival attribute
     *
     * @return boolean True when trip is sorted, false when there is one than more route arround boarding cards
     */
    public function sort()
    {
        if (count($this->getBoardingCards()) <= 1) {
            return true;
        }

        $routes = array();

        foreach ($this->getBoardingCards() as $boardingCard) {
            $added = false;

            foreach ($routes as $k => $route) {
                if ($boardingCard->getDeparture() == end($route)->getArrival()) {
                    if (!$added) {
                        $routes[$k][] = $boardingCard;
                        $added = true;
                    } else {
                        $routes = $this->mergeRoutes($routes);
                        continue;
                    }
                }

                if ($boardingCard->getArrival() == reset($route)->getDeparture()) {
                    if (!$added) {
                        array_unshift($routes[$k], $boardingCard);
                        $added = true;
                    } else {
                        $routes = $this->mergeRoutes($routes);
                        continue;
                    }
                }

            }

            if (!$added) {
                $routes[] = array($boardingCard);
            }
        }

        if (count($routes) != 1) {
            return false;
        }

        $this->boardingCards = array_pop($routes);

        return true;
    }

    /**
     * Return boarding cards
     *
     * @return array
     */
    public function getBoardingCards()
    {
        return $this->boardingCards;
    }

    /**
     * Method merge routes
     *
     * @param array $routes
     *
     * @return array
     */
    private function mergeRoutes(array $routes)
    {
        if (count($routes) == 1) { //roundtrip case
            return $routes;
        }

        $output = array();

        $first = array_shift($routes);
        $last = array_shift($routes);

        if (end($first)->getArrival() == reset($last)->getDeparture()) {
            $output = array_merge($first, $last);
        } else {
            $output = array_merge($last, $first);
        }

        return array($output);
    }

    /**
     * Returns sorted list of boarding cards
     *
     * @return array
     */
    public function getSummary()
    {
        if (!$this->sort()) {
            return false;
        }

        $boardingCards = $this->getBoardingCards();

        $output = array();
        $lastCard = null;
        foreach ($boardingCards as $card) {
            $output[] = $card->getDescription($lastCard);
            $lastCard =$card;
        }

        if (count($output) > 0) {
            $output[] = 'You have arrived at your final destination.';
        }

        return $output;
    }
}