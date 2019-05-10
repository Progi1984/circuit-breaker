<?php

namespace Tests\PrestaShop\CircuitBreaker\Places;

use PrestaShop\CircuitBreaker\Exceptions\InvalidPlaceException;
use PrestaShop\CircuitBreaker\Places\HalfOpenPlace;
use PrestaShop\CircuitBreaker\States;

class HalfOpenPlaceTest extends PlaceTestCase
{
    /**
     * @dataProvider getFixtures
     *
     * @param mixed $failures
     * @param mixed $timeout
     * @param mixed $threshold
     */
    public function testCreationWith($failures, $timeout, $threshold)
    {
        $halfOpenPlace = new HalfOpenPlace($failures, $timeout, $threshold);

        $this->assertSame($failures, $halfOpenPlace->getFailures());
        $this->assertSame($timeout, $halfOpenPlace->getTimeout());
        $this->assertSame($threshold, $halfOpenPlace->getThreshold());
    }

    /**
     * @dataProvider getInvalidFixtures
     *
     * @param mixed $failures
     * @param mixed $timeout
     * @param mixed $threshold
     */
    public function testCreationWithInvalidValues($failures, $timeout, $threshold)
    {
        $this->expectException(InvalidPlaceException::class);

        new HalfOpenPlace($failures, $timeout, $threshold);
    }

    /**
     * @dataProvider getArrayFixtures
     *
     * @param array $settings
     */
    public function testFromArrayWith(array $settings)
    {
        $halfOpenPlace = HalfOpenPlace::fromArray($settings);

        $this->assertNotNull($halfOpenPlace);
    }

    /**
     * @dataProvider getInvalidArrayFixtures
     *
     * @param array $settings
     */
    public function testFromArrayWithInvalidValues(array $settings)
    {
        $this->expectException(InvalidPlaceException::class);

        HalfOpenPlace::fromArray($settings);
    }

    public function testGetExpectedState()
    {
        $halfOpenPlace = new HalfOpenPlace(1, 1, 1);

        $this->assertSame(States::HALF_OPEN_STATE, $halfOpenPlace->getState());
    }
}
