<?php

namespace TripSorter\Tests;

use TripSorter\Cards\AirplaneCard;
use TripSorter\Definition\BoardingCard;

/**
 * Test suite for airplane card
 *
 * @author Pawel Wilk <pwilkmielno@gmail.com>
 *
 * @group cards
 */
class AirplaneCardTest extends \PHPUnit_Framework_TestCase
{
    public function testTransferBaggageForCardDifferentType()
    {
        $mockedCard = $this->getMockBuilder('TripSorter\Definition\BoardingCard')
                           ->disableOriginalConstructor()
                           ->getMock();

        $airplaneCard = new AirplaneCard('DXB', 'CDG', 'AF1241', '65F', '18A');

        $this->assertFalse($airplaneCard->isBaggageTransfered($mockedCard));
    }

    public function testTransferLuggageFirstTravelPoint()
    {
        $airplaneCard = new AirplaneCard('DXB', 'CDG', 'AF1241', '65F', '18A');

        $this->assertFalse($airplaneCard->isBaggageTransfered(null));
    }

    public function testTrasferLuggageTransfered()
    {
        $mockedCard = $this->getMockBuilder('TripSorter\Cards\AirplaneCard')
                           ->disableOriginalConstructor()
                           ->getMock();
        $mockedCard->expects($this->exactly(1))
                   ->method('getTransferBaggage')
                   ->will($this->returnValue(true));

        $airplaneCard = new AirplaneCard('DXB', 'CDG', 'AF1241', '65F', '18A');

        $this->assertTrue($airplaneCard->isBaggageTransfered($mockedCard));
    }

    public function testTrasferLuggageNotTransfered()
    {
        $mockedCard = $this->getMockBuilder('TripSorter\Cards\AirplaneCard')
                           ->disableOriginalConstructor()
                           ->getMock();
        $mockedCard->expects($this->exactly(1))
                   ->method('getTransferBaggage')
                   ->will($this->returnValue(false));

        $airplaneCard = new AirplaneCard('DXB', 'CDG', 'AF1241', '65F', '18A');

        $this->assertFalse($airplaneCard->isBaggageTransfered($mockedCard));
    }

    public function testDescriptionFirstNoBaggageDrop()
    {
        $airplaneCard = new AirplaneCard('DXB', 'CDG', 'AF1241', '65F', '18A');

        $this->assertEquals('From DXB, take flight AF1241 to CDG. Gate 65F, seat 18A.', $airplaneCard->getDescription());
    }

    public function testDescriptionWithBaggageDrop()
    {
        $airplaneCard = new AirplaneCard('DXB', 'CDG', 'AF1241', '65F', '18A', '77B');

        $this->assertEquals('From DXB, take flight AF1241 to CDG. Gate 65F, seat 18A. Baggage drop at ticket counter 77B.', $airplaneCard->getDescription());
    }

    public function testDescriptionWithBaggageTransfer()
    {
        $mockedCard = $this->getMockBuilder('TripSorter\Cards\AirplaneCard')
                           ->disableOriginalConstructor()
                           ->getMock();
        $mockedCard->expects($this->exactly(1))
                   ->method('getTransferBaggage')
                   ->will($this->returnValue(true));

        $airplaneCard = new AirplaneCard('DXB', 'CDG', 'AF1241', '65F', '18A', '77B');

        $this->assertEquals('From DXB, take flight AF1241 to CDG. Gate 65F, seat 18A. Baggage will we automatically transferred from your last leg.', $airplaneCard->getDescription($mockedCard));
    }

}