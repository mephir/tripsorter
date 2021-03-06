<?php

namespace TripSorter\Tests;

use TripSorter\Cards\VehicleCard;

/**
 * Test suite for train card
 *
 * @author Pawel Wilk <pwilkmielno@gmail.com>
 *
 * @group cards
 */
class VehicleCardTest extends \PHPUnit_Framework_TestCase
{
    public function testDescriptionWithoutSeat()
    {
        $trainCard = new VehicleCard('Paris St. Lazare', 'London St. Pancras International', 'train 1774');

        $this->assertEquals('Take train 1774 from Paris St. Lazare to London St. Pancras International. No seat assignment.', $trainCard->getDescription());
    }

    public function testDescriptionWithSeat()
    {
        $trainCard = new VehicleCard('Paris St. Lazare', 'London St. Pancras International', 'train 1774', 59);

        $this->assertEquals('Take train 1774 from Paris St. Lazare to London St. Pancras International. Sit in seat 59.', $trainCard->getDescription());
    }
}