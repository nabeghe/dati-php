# Dati (Date Time Helper for PHP)

> A simple DateTime helper for common stuff.

Converting dates between the Gregorian and Jalali (Shamsi/Persian) calendars and vice versa,
Checking the validity of Gregorian and Jalali dates,
spam detection based on datetime sequences,
detecting datetime formats,
calculating the difference between two datetimes in a preferred unit or the largest possible unit,
remaining time between two datetimes based on validity,
checking for leap years in both Gregorian and Jalali calendars,
adding a value to a datetime,
converting timezones to a desired or local one,
month names, month lengths, current time, and so on!

<b style="color: red">Notice:</b> To convert Gregorian dates to Jalali and vice versa, the `intl` extension must be enabled in PHP.

## 🫡 Usage

### 🚀 Installation

You can install the package via composer:

```bash
composer require nabeghe/dati
```

### Dati Class

#### Example 1:

```php
use Nabeghe\Dati\Dati;

# Convert Gregorian to Jalali
echo "1995-11-20 00:00:00 To Jalali = ".Dati::toJalali('1995-11-20 00:00:00')."\n"; // 1374-08-29 00:00:00

# Convert Jalali to Gregorian
echo "1374-08-29 00:00:00 To Jalali = ".Dati::fromJalali('1374-08-29 00:00:00')."\n"; // 1995-11-20 00:00:00

# Detect Format:
echo '1995-11-20 00:00:00 Format = '.Dati::detectFormat('1995-11-20 00:00:00')."\n"; // Y-m-d H:i:s

# Difference between two datetimes:
echo 'Diff between 1995-11-20 00:00:00 & 1995-11-20 00:00:01 = '.Dati::diff('1995-11-20 00:00:00', '1995-11-20 00:00:01')."\n"; // 1 seconds
echo 'Diff between 1995-11-20 00:00:00 & 1995-11-31 00:00:00 = '.Dati::diff('1995-11-20 00:00:00', '1995-11-31 00:00:00', 'days')."\n"; // 11 days
echo 'Diff between 1995-11-20 00:00:00 & 1995-11-31 12:00:00 = '.Dati::diff('1995-11-20 00:00:00', '1995-11-31 12:00:00', 'days')."\n"; // 11.5 days
echo 'Diff between 1995-11-20 00:00:00 & 2024-10-19 22:58:00 = '.((int) Dati::diff('1995-11-20 00:00:00', '2024-10-19 22:58:00', 'years'))."\n"; // 28 years

# Difference between two dates based on largest possible unit:
echo "How Long Ago From 2024-10-19 00:00:00 to 2025-10-19 00:00:00 = ".json_encode(Dati::howLongAgo('2024-10-19 00:00:00', '2025-10-19 00:00:00'))."\n";
// Output: {"unit":"years","value":1,"diff":31536000}

# Check leap Year
echo 'Year 2024 gregorian '.Dati::isLeap(2024) ? "is leap\n" : "is not leap\n";
echo 'Year 1403 Jalali '.Dati::isLeap(1403, true) ? "is leap\n" : "is not leap\n";

# Join a value to datetime:
echo 'Join 1 secoonds to 1995-11-20 00:00:00 = '.Dati::join('+1', 'seconds', '1995-11-20 00:00:00')."\n"; // 1995-11-20 00:00:0
echo 'Join 2 weeks to 1995-11-20 00:00:00 = '.Dati::join('+2', 'weeks', '1995-11-20 00:00:00')."\n"; // 1995-12-04 00:00:00
echo 'Join 3 months to 1995-11-20 00:00:00 = '.Dati::join('3', 'month', '1995-11-20 00:00:00')."\n"; // 1996-02-20 00:00:00

# Remaining value until expiration! Suitable for things like premium subscriptions that have validity:
echo 'Remaining minutes to reach 2024-10-20 00:00:00 since 2024-10-19 23:00:00 = '.Dati::remaining('2024-10-19 23:00:00', '2024-10-20 00:00:00', 60, 'minutes')."\n"; // 0
echo 'Remaining minutes to reach 2024-10-20 00:00:00 since 2024-10-19 23:00:00 '.((int) Dati::remaining('2024-10-19 23:00:00', '2024-10-20 00:00:00', 120, 'minutes'))."\n"; // 60

echo 'Parsed Unit `1s` = '.json_encode(Dati::parseUnit('1s'))."\n"; // [1,"seconds"]
echo 'Parsed Unit `1S` = '.json_encode(Dati::parseUnit('1S'))."\n"; // [1,"seconds"]
echo 'Parsed Unit `1sec` = '.json_encode(Dati::parseUnit('1sec'))."\n"; // [1,"seconds"]
echo 'Parsed Unit `1Sec` = '.json_encode(Dati::parseUnit('1Sec'))."\n"; // [1,"seconds"]
echo 'Parsed Unit `1second` = '.json_encode(Dati::parseUnit('1second'))."\n"; // [1,"seconds"]
echo 'Parsed Unit `1Second` = '.json_encode(Dati::parseUnit('1Second'))."\n"; // [1,"seconds"]
echo 'Parsed Unit `1seconds` = '.json_encode(Dati::parseUnit('1seconds'))."\n"; // [1,"seconds"]
echo 'Parsed Unit `1Seconds` = '.json_encode(Dati::parseUnit('1Seconds'))."\n"; // [1,"seconds"]
echo 'Parsed Unit `1 s` = '.json_encode(Dati::parseUnit('1 s'))."\n"; // [1,"seconds"]
echo 'Parsed Unit ` 1 s ` = '.json_encode(Dati::parseUnit('1 s '))."\n"; // [1,"seconds"]
echo 'Parsed Unit `2m` = '.json_encode(Dati::parseUnit('2m'))."\n"; // [2,"minutes"]
echo 'Parsed Unit `3h` = '.json_encode(Dati::parseUnit('3h'))."\n"; // [3,"hours"]
echo 'Parsed Unit `4d` = '.json_encode(Dati::parseUnit('4d'))."\n"; // [4,"days"]
echo 'Parsed Unit `5w` = '.json_encode(Dati::parseUnit('5w'))."\n"; // [5,"weeks"]
echo 'Parsed Unit `6M` = '.json_encode(Dati::parseUnit('6M'))."\n"; // [6,"months"]
echo 'Parsed Unit `7y` = '.json_encode(Dati::parseUnit('7y'))."\n"; // [7,"years"]
```

#### Example 2 - Check Spam:

Sometimes it is necessary to check the datetime of an action to determine if it is spam.
For example, reviewing the last ten datetimes of messages or tickets that have been sent.

```php
// Syntax:
Diff::checkSpam(array $datetimes, int $offset = 1, int $limit = 3, $strict = false)
```

- `datetimes`: Sequence of datetimes.
- `offset`: If the difference between two consecutive datetimes is equal to or less than this amount, a warning indicating potential spam has occurred.
- `limit`: Receiving how many warning indicates spam?
- `strict`: If it's not strict, if no warning is received between two consecutive datetimes, one of the previous warnings will be reduced.

```php
use Nabeghe\Dati\Dati;

if (Dati::checkSpam([
    '2024-10-19 22:46:01',
    '2024-10-19 22:46:02',
    '2024-10-19 22:46:03',
    '2024-10-19 22:46:04',
])) {
    echo "Spam 1\n";
}

if (Dati::checkSpam([
    '2024-10-19 22:46:01',
    '2024-10-19 22:46:01',
    '2024-10-19 22:46:01',
    '2024-10-19 22:46:01',
])) {
    echo "Spam 2\n";
}

if (!Dati::checkSpam([
    '2024-10-19 22:46:01',
    '2024-10-19 22:46:02',
    '2024-10-19 22:46:03',
])) {
    echo "Not Spam 3\n";
}

if (!Dati::checkSpam([
    '2024-10-19 22:46:01',
    '2024-10-19 22:46:03',
    '2024-10-19 22:46:03',
    '2024-10-19 22:46:03',
])) {
    echo "Not Spam 4\n";
}
```

### Months Class

Access to the names and lengths of the months in the Gregorian, Jalali, and lunar calendars.

```php
use Nabeghe\Dati\Months;

echo "Month Length 2024/11: " . Months::length(2024, 11) . "\n"; // 30
echo "Month Length 2024/12: " . Months::length(2024, 12) . "\n"; // 31
echo "Month Length 1402/12 (Jalali): " . Months::length(1402, 12,  'jalali') . "\n"; // 29
echo "Month Length 1403/12 (Jalali): " . Months::length(1403, 12,  'jalali') . "\n"; // 30
echo "Month Length 1404/12 (Jalali): " . Months::length(1404, 12,  'jalali') . "\n"; // 29

echo "Month Name 11: " . Months::name(11, 'gregorian', true) . "\n"; // November
echo "Month Name 11: " . Months::name(11, 'gregorian', false) . "\n"; // نوامبر
```

### Now Class

Access to the current datetime.

#### Example 1:

```php
use Nabeghe\Dati\Now;

echo "Now (GMT): " . Now::datetime() . "\n";
echo "Now (GMT): " . Now::datetime() . "\n"; // The output will be the same as before. The time has been cached.
echo "Now (Local): " . Now::datetimeNew() . "\n";
echo "Now (Local): " . Now::datetimeLocal() . "\n";
echo "Now (Local): " . Now::datetimeLocal() . "\n"; // The output will be the same as before. The time has been cached.
echo "Now (Local): " . Now::datetimeLocalNew() . "\n";
```

#### Example 2 - Initialization with previous values

If it is necessary to use a previously obtained datetime.

```php
use Nabeghe\Dati\Now;

Now::init('1995-11-20 00:00:00', '1995-11-20 13:14:00');

echo "Now (GMT): " . Now::datetime() . "\n"; // 1995-11-20 00:00:00
echo "Now (Local): " . Now::datetimeLocal() . "\n"; // 1995-11-20 13:14:00
```

## 📖 License

Licensed under the MIT license, see [LICENSE.md](LICENSE.md) for details.