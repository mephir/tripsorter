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
        $this->assertFalse($collection->getSummary());
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

        $summary = $collection->getSummary();

        $this->assertCount(5, $summary);

        $results = array(
            'Take train 78A from Madrid to Barcelona. Sit in seat 45B.',
            'Take airport bus from Barcelona to Gerona Airport. No seat assignment.',
            'From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A. Baggage drop at ticket counter 344.',
            'From Stockholm, take flight SK22 to New York JFK. Gate 22, seat 7B. Baggage will we automatically transferred from your last leg.',
            'You have arrived at your final destination.',
        );

        foreach ($results as $point) {
            $this->assertEquals($point, array_shift($summary));
        }
    }

    public function testVeryLong()
    {
        $collection = new TripCollection();

        $collection->add(new VehicleCard('C', 'D', 'train CD'));
        $collection->add(new VehicleCard('A', 'B', 'bus AB'));
        $collection->add(new VehicleCard('E', 'F', 'train EF'));
        $collection->add(new VehicleCard('G', 'H', 'bus GH'));
        $collection->add(new VehicleCard('D', 'E', 'train DE'));
        $collection->add(new VehicleCard('B', 'C', 'bus BC'));
        $collection->add(new VehicleCard('F', 'G', 'train FG'));

        $this->assertTrue($collection->sort());
    }
}