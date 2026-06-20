<?php
namespace Tests\Unit;
use PHPUnit\Framework\TestCase;
use App\Models\Event;

class EventTest extends TestCase
{
    public function test_event_can_be_instantiated_with_capacity()
    {
        $event = new Event();
        $event->title = "Bieg Wiosenny";
        $event->capacity = 50;

        $this->assertEquals("Bieg Wiosenny", $event->title);
        $this->assertEquals(50, $event->capacity);
    }

    public function test_event_has_available_spots()
    {
        $event = new Event();
        $event->capacity = 10;
        $registeredUsersCount = 5; 

        $hasSpots = ($event->capacity - $registeredUsersCount) > 0;

        $this->assertTrue($hasSpots);
    }
}