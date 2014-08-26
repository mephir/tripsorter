# TripSorter

TripSorter is library which support tickets/boarding cards sorting in to unbreakable chain. It supports A-B travels as well as roundtrips. In case of roundtrips proper starting point cannot be guaranted.

## Requirement
 * PHP 5.3+
 * PHPUnit 3.17+

## Usage
 1. TripSorter follows the standards defined in the [PSR-0](http://www.php-fig.org/psr/psr-0/), [PSR-1](http://www.php-fig.org/psr/psr-1/) and [PSR-2](http://www.php-fig.org/psr/psr-2/) documents. Could be used with PSR-0 autoloader, for an example from composer.
 2. Include file src/autoload.php into your scripts for using library
 3. If your project uses SplAutoloader classes you can register TripSorter under namespace ```TripSorter``` pointing to src/TripSorter folder

## Testing
TripSorter is using phpunit for testing. phpunit configuration file is provided and included in to repository.
For running tests you should go to main directory and run phpunit command without additional parameters.

## Possible changes
 * Support trips when user stops multiple time in the same point
 * Refactoring of ```VehicleCard class```. Create abstract class from it, which does not support train/bus number by name field. It can have getName() abstract method, by creating classes as TrainCard, BusCard(which will inherit from VehicleCard) can support directy train/bus number.
 * Naming convention: rename BoardingCard to Ticket and make similar naming change in child classes.
 * Adding informations to AirplaneCard about allowed baggage
 * Adding support for setting first trip point(guarantee proper chain for roundtrips)
 * Add composer.json

## Create new types of transportation
 1. Create new class which extends ```TripSorter\Definition\BoardingCard```.
 2. Create ```getDescription()``` method which returns description of ticket.
 3. Add your own code, additional information etc.

New types of transportation:
 * Bareboat charter - with additional information about boat name and if point of trip is final one by this type of transportation(similar like luggage transfer)
 * Cruise ship - additional data like cabin number, desk number
 * Taxi - with price
 * Extending train card for informations if its regular train or fast trains like(TGV, Eurostar, Thalys) since boarding rules are different

## Example usage
Code:
```php
<?php
use TripSorter\Collection\TripCollection;
use TripSorter\Cards\AirplaneCard;
use TripSorter\Cards\VehicleCard;

include('src/autoload.php');

$collection = new TripCollection();

$collection->add(new VehicleCard('Barcelona', 'Gerona Airport', 'airport bus'));
$collection->add(new AirplaneCard('Stockholm', 'New York JFK', 'SK22', 22, '7B'));
$collection->add(new AirplaneCard('Gerona Airport', 'Stockholm', 'SK455', '45B', '3A', 344));
$collection->add(new VehicleCard('Madrid', 'Barcelona', 'train 78A', '45B'));

$i = 1;
foreach ($collection->getSummary() as $point) {
    echo sprintf("%d. %s\n", $i, $point);
    $i++;
}
```
Result:
```
mephir@ns361912 ~/git/TripSorter $ php -f example.php
1. Take train 78A from Madrid to Barcelona. Sit in seat 45B.
2. Take airport bus from Barcelona to Gerona Airport. No seat assignment.
3. From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A. Baggage drop at ticket counter 344.
4. From Stockholm, take flight SK22 to New York JFK. Gate 22, seat 7B. Baggage will we automatically transferred from your last leg.
5. You have arrived at your final destination.
```

## License
MIT license

.. _`PSR-0`: http://www.php-fig.org/psr/psr-0/
.. _`PSR-1`: http://www.php-fig.org/psr/psr-1/
.. _`PSR-2`: http://www.php-fig.org/psr/psr-2/