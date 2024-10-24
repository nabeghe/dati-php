<?php declare(strict_types=1);

use Nabeghe\Dati\Dati;

class DatiTest extends \PHPUnit\Framework\TestCase
{
    public function testCheckDate()
    {
        $this->assertTrue(Dati::checkDate(11, 20, 1995));
        $this->assertTrue(Dati::checkDate(10, 19, 2024));
        $this->assertFalse(Dati::checkDate(13, 19, 2024));
        $this->assertTrue(Dati::checkDate(8, 29, 1374, true));
        $this->assertTrue(Dati::checkDate(7, 28, 1403, true));
        $this->assertFalse(Dati::checkDate(13, 28, 1403, true));
    }

    public function testCheckSpamYesWithDefaultValues1()
    {
        $this->assertTrue(Dati::checkSpam([
            '2024-10-19 22:46:01',
            '2024-10-19 22:46:02',
            '2024-10-19 22:46:03',
            '2024-10-19 22:46:04',
        ]));
    }

    public function testCheckSpamYesWithDefaultValues2()
    {
        $this->assertTrue(Dati::checkSpam([
            '2024-10-19 22:46:01',
            '2024-10-19 22:46:01',
            '2024-10-19 22:46:01',
            '2024-10-19 22:46:01',
        ]));
    }

    public function testCheckSpamNoWithDefaultValues1()
    {
        $this->assertFalse(Dati::checkSpam([
            '2024-10-19 22:46:01',
            '2024-10-19 22:46:02',
            '2024-10-19 22:46:03',
        ]));
    }

    public function testCheckSpamNoWithDefaultValues2()
    {
        $this->assertFalse(Dati::checkSpam([
            '2024-10-19 22:46:01',
            '2024-10-19 22:46:03',
            '2024-10-19 22:46:03',
            '2024-10-19 22:46:03',
        ]));
    }

    public function testDetectFormat()
    {
        $this->assertSame('Y-m-d', Dati::detectFormat('1995-11-20'));
        $this->assertSame('Y/m/d', Dati::detectFormat('1995/11/20'));
        $this->assertSame('m-d-Y', Dati::detectFormat('11-20-1995'));
        $this->assertSame('d-m-Y', Dati::detectFormat('20-11-1995'));
        $this->assertSame('Y-m-d H:i:s', Dati::detectFormat('1995-11-20 00:00:00'));
    }

    public function testDiff()
    {
        $this->assertEquals(1, Dati::diff('1995-11-20 00:00:00', '1995-11-20 00:00:01'));
        $this->assertEquals(11, Dati::diff('1995-11-20 00:00:00', '1995-11-31 00:00:00', 'days'));
        $this->assertEquals(11.5, Dati::diff('1995-11-20 00:00:00', '1995-11-31 12:00:00', 'days'));
        $this->assertEquals(28, (int) Dati::diff('1995-11-20 00:00:00', '2024-10-19 22:58:00', 'years'));
    }

    public function testFromJalali()
    {
        $this->assertSame('1995-11-20', Dati::fromJalali("1374-08-29"));
        $this->assertSame('1995-11-20 00:00:00', Dati::fromJalali("1374-08-29 00:00:00"));
        $this->assertSame('2024-11-20', Dati::fromJalali("1403-08-30"));
        $this->assertSame('2024-11-20 00:00:00', Dati::fromJalali("1403-08-30 00:00:00"));
    }

    public function testHowLongAgo()
    {
        $this->assertEquals(
            ['unit' => 'years', 'value' => 1, 'diff' => 31536000],
            Dati::howLongAgo('2024-10-19 00:00:00', '2025-10-19 00:00:00'),
        );
    }

    public function testIsLeap()
    {
        $this->assertTrue(Dati::isLeap(2024));
        $this->assertFalse(Dati::isLeap(2025));
        $this->assertTrue(Dati::isLeap(2028));
        $this->assertFalse(Dati::isLeap(1402, true));
        $this->assertTrue(Dati::isLeap(1403, true));
        $this->assertFalse(Dati::isLeap(1404, true));
        $this->assertTrue(Dati::isLeap(1408, true));
    }

    public function testJoin()
    {
        $this->assertSame('1995-11-20 00:00:01', Dati::join('+1', 'seconds', '1995-11-20 00:00:00'));
        $this->assertSame('1995-11-20 00:00:02', Dati::join('+2', 'seconds', '1995-11-20 00:00:00'));
        $this->assertSame('1995-12-20 00:00:00', Dati::join('+1', 'month', '1995-11-20 00:00:00'));
    }

    public function testRemaining()
    {
        $this->assertEquals(0, Dati::remaining('2024-10-19 23:00:00', '2024-10-20 00:00:00', 60, 'minutes'));
        $this->assertEquals(60, (int) Dati::remaining('2024-10-19 23:00:00', '2024-10-20 00:00:00', 120, 'minutes'));
    }

    public function testParseUnit()
    {
        $this->assertEquals([1, 'seconds'], Dati::parseUnit('1s'));
        $this->assertEquals([1, 'seconds'], Dati::parseUnit('1S'));
        $this->assertEquals([1, 'seconds'], Dati::parseUnit('1second'));
        $this->assertEquals([1, 'seconds'], Dati::parseUnit('1seconds'));
        $this->assertEquals([1, 'seconds'], Dati::parseUnit('1 seconds'));
        $this->assertEquals([1, 'seconds'], Dati::parseUnit(' 1 seconds '));

        $this->assertEquals([2, 'minutes'], Dati::parseUnit('2m'));
        $this->assertEquals([2, 'minutes'], Dati::parseUnit('2min'));
        $this->assertEquals([2, 'minutes'], Dati::parseUnit('2Min'));
        $this->assertEquals([2, 'minutes'], Dati::parseUnit('2minutes'));
        $this->assertEquals([2, 'minutes'], Dati::parseUnit('2 minutes'));
        $this->assertEquals([2, 'minutes'], Dati::parseUnit(' 2 minutes '));

        $this->assertEquals([3, 'hours'], Dati::parseUnit('3h'));
        $this->assertEquals([3, 'hours'], Dati::parseUnit('3H'));
        $this->assertEquals([3, 'hours'], Dati::parseUnit('3hour'));
        $this->assertEquals([3, 'hours'], Dati::parseUnit('3hours'));
        $this->assertEquals([3, 'hours'], Dati::parseUnit('3 hours'));
        $this->assertEquals([3, 'hours'], Dati::parseUnit(' 3 hours '));

        $this->assertEquals([4, 'days'], Dati::parseUnit('4d'));
        $this->assertEquals([4, 'days'], Dati::parseUnit('4D'));
        $this->assertEquals([4, 'days'], Dati::parseUnit('4day'));
        $this->assertEquals([4, 'days'], Dati::parseUnit('4days'));
        $this->assertEquals([4, 'days'], Dati::parseUnit('4 days'));
        $this->assertEquals([4, 'days'], Dati::parseUnit(' 4 days '));

        $this->assertEquals([5, 'weeks'], Dati::parseUnit('5w'));
        $this->assertEquals([5, 'weeks'], Dati::parseUnit('5W'));
        $this->assertEquals([5, 'weeks'], Dati::parseUnit('5week'));
        $this->assertEquals([5, 'weeks'], Dati::parseUnit('5weeks'));
        $this->assertEquals([5, 'weeks'], Dati::parseUnit('5 weeks'));
        $this->assertEquals([5, 'weeks'], Dati::parseUnit(' 5 weeks '));

        $this->assertEquals([6, 'months'], Dati::parseUnit('6M'));
        $this->assertEquals([6, 'months'], Dati::parseUnit('6month'));
        $this->assertEquals([6, 'months'], Dati::parseUnit('6months'));
        $this->assertEquals([6, 'months'], Dati::parseUnit('6 months'));
        $this->assertEquals([6, 'months'], Dati::parseUnit(' 6 months '));

        $this->assertEquals([7, 'years'], Dati::parseUnit('7y'));
        $this->assertEquals([7, 'years'], Dati::parseUnit('7Y'));
        $this->assertEquals([7, 'years'], Dati::parseUnit('7year'));
        $this->assertEquals([7, 'years'], Dati::parseUnit('7years'));
        $this->assertEquals([7, 'years'], Dati::parseUnit('7 years'));
        $this->assertEquals([7, 'years'], Dati::parseUnit(' 7 years '));
    }

    public function testToJalali()
    {
        $this->assertSame('1374-08-29', Dati::toJalali("1995-11-20"));
        $this->assertSame('1374-08-29 00:00:00', Dati::toJalali("1995-11-20 00:00:00"));
        $this->assertSame('1403-08-30', Dati::toJalali("2024-11-20"));
        $this->assertSame('1403-08-30 00:00:00', Dati::toJalali("2024-11-20 00:00:00"));
    }
}