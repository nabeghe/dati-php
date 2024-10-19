<?php declare(strict_types=1);

use Nabeghe\Dati\Months;

class MonthsTest extends \PHPUnit\Framework\TestCase
{
    public function testLength()
    {
        $this->assertSame(30, Months::length(2024, 11));
        $this->assertSame(31, Months::length(2024, 12));
        $this->assertSame(29, Months::length(1402, 12,  'jalali'));
        $this->assertSame(30, Months::length(1403, 12,  'jalali'));
        $this->assertSame(29, Months::length(1404, 12,  'jalali'));
    }

    public function testNamesGregorian()
    {
        $gregorians = [
            ['January', 'ژانویه'],
            ['February', 'فوریه'],
            ['March', 'مارس'],
            ['April', 'آوریل'],
            ['May', 'مه'],
            ['June', 'ژوئن'],
            ['July', 'ژوئیه'],
            ['August', 'اوت'],
            ['September', 'سپتامبر'],
            ['October', 'اکتبر'],
            ['November', 'نوامبر'],
            ['December', 'دسامبر'],
        ];

        for ($i = 0; $i < count($gregorians); $i++) {
            $this->assertSame($gregorians[$i][0], Months::name($i + 1, 'gregorian', true));
            $this->assertSame($gregorians[$i][1], Months::name($i + 1, 'gregorian', false));
        }
    }

    public function testNamesJalali()
    {
        $gregorians = [
            ['Farvardin', 'فروردین'],
            ['Ordibehesht', 'اردیبهشت'],
            ['Khordad', 'خرداد'],
            ['Tir', 'تیر'],
            ['Mordad', 'مرداد'],
            ['Shahrivar', 'شهریور'],
            ['Mehr', 'مهر'],
            ['Aban', 'آبان'],
            ['Azar', 'آذر'],
            ['Dey', 'دی'],
            ['Bahman', 'بهمن'],
            ['Esfand', 'اسفند'],
        ];

        for ($i = 0; $i < count($gregorians); $i++) {
            $this->assertSame($gregorians[$i][0], Months::name($i + 1, 'jalali', true));
            $this->assertSame($gregorians[$i][1], Months::name($i + 1, 'jalali', false));
        }
    }

    public function testNamesLunar()
    {
        $gregorians = [
            ['Muharram', 'محرم'],
            ['Safar', 'صفر'],
            ['Rabi\' al-Awwal', 'ربیع‌الاول'],
            ['Rabi\' al-Thani', 'ربیع‌الثانی'],
            ['Jumada al-Awwal', 'جمادی‌الاول'],
            ['Jumada al-Thani', 'جمادی‌الثانی'],
            ['Rajab', 'رجب'],
            ['Sha\'ban', 'شعبان'],
            ['Ramadan', 'رمضان'],
            ['Shawwal', 'شوال'],
            ['Dhu al-Qi\'dah', 'ذوالقعده'],
            ['Dhu al-Hijjah', 'ذوالحجه'],
        ];

        for ($i = 0; $i < count($gregorians); $i++) {
            $this->assertSame($gregorians[$i][0], Months::name($i + 1, 'lunar', true));
            $this->assertSame($gregorians[$i][1], Months::name($i + 1, 'lunar', false));
        }
    }
}