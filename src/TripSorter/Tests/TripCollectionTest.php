<?php

namespace TripSorter\Tests;

use TripSorter\Collection\TripCollection;
use TripSorter\Cards\VehicleCard;
use TripSorter\Cards\AirplaneCard;

/**
 * Test suite for trip collection
 *
 * @author Pawel Wilk <pwilkmielno@gmail.com>
 *
 * @group collection
 */
class TripCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testCollectionSortTripInvalid()
    {
        $collection = new TripCollection();

        $collection->add(new VehicleCard('C', 'D', 'train CD'));
        $collection->add(new VehicleCard('A', 'B', 'bus AB'));
        $collection->add(new VehicleCard('B', 'C', 'bus BC'));
        $collection->add(new VehicleCard('E', 'F', 'train EF'));

        $this->assertFalse($collection->sort());

    }

    public function testCollectionSortTripValid()
    {
        $collection = new TripCollection();

        $collection->add(new VehicleCard('C', 'D', 'train CD'));
        $collection->add(new VehicleCard('A', 'B', 'bus AB'));
        $collection->add(new VehicleCard('D', 'E', 'train DE'));
        $collection->add(new VehicleCard('B', 'C', 'bus BC'));
        $collection->add(new VehicleCard('E', 'F', 'train EF'));

        $this->assertTrue($collection->sort());

        $departures = array('A', 'B', 'C', 'D', 'E');
        $arrivals = array('B', 'C', 'D', 'E', 'F');
        $cards = $collection->getBoardingCards();

        foreach ($cards as $k => $card) {
            $this->assertEquals($departures[$k], $card->getDeparture());
            $this->assertEquals($arrivals[$k], $card->getArrival());
        }

    }

    public function testCollectionSortTripRoundtrip()
    {
        $collection = new TripCollection();

        $collection->add(new VehicleCard('C', 'D', 'train CD'));
        $collection->add(new VehicleCard('A', 'B', 'bus AB'));
        $collection->add(new VehicleCard('D', 'E', 'train DE'));
        $collection->add(new VehicleCard('B', 'C', 'bus BC'));
        $collection->add(new VehicleCard('E', 'F', 'train EF'));
        $collection->add(new VehicleCard('F', 'A', 'bus FA'));

        $this->assertTrue($collection->sort());
    }

    public function testCollectionTaskDescription()
    {
        $collection = new TripCollection();

        $collection->add(new VehicleCard('Barcelona', 'Gerona Airport', 'airport bus'));
        $collection->add(new AirplaneCard('Stockholm', 'New York JFK', 'SK22', 22, '7B'));
        $collection->add(new AirplaneCard('Gerona Airport', 'Stockholm', 'SK455', '45B', '3A', 344));
        $collection->add(new VehicleCard('Madrid', 'Barcelona', 'train 78A', '45B'));

        var_dump($collection->getSummary());
    }
}