This is a proof of concept only. Not ready for production.

## String enumeration:

```php
use AndreyRed\Enum\Annotation\EnumOption;
use AndreyRed\Enum\StringEnumeration;

final class TestStringEnum extends StringEnumeration
{
    /** @EnumOption(value="one", name="Option one") */
    public static function firstOption(): self
    {
        return self::fromMethodName(__FUNCTION__);
    }

    /** @EnumOption(value="two") */
    public static function secondOption(): self
    {
        return self::fromMethodName(__FUNCTION__);
    }

    /** @EnumOption(name="Option three") */
    public static function thirdOption(): self
    {
        return self::fromMethodName(__FUNCTION__);
    }

    /** @EnumOption */
    public static function fourthOption(): self
    {
        return self::fromMethodName(__FUNCTION__);
    }
}
```

## Integer enumeration

```php
use AndreyRed\Enum\Annotation\EnumOption;
use AndreyRed\Enum\IntegerEnumeration;

final class TestIntegerEnum extends IntegerEnumeration
{
    /** @EnumOption(value=1, name="Option one") */
    public static function firstOption(): self
    {
        return self::fromMethodName(__FUNCTION__);
    }

    /** @EnumOption(value=2) */
    public static function secondOption(): self
    {
        return self::fromMethodName(__FUNCTION__);
    }
}
```

## Usage

### Instantiation

```php
$one = TestIntegerEnum::firstOption();
$anotherOne = TestIntegerEnum::fromValue(1);
$two = TestIntegerEnum::secondOption();
```

### Comparison

```php
assertTrue($one === $anotherOne);
assertFalse($one === $two);
assertTrue($one->oneOf([$anotherOne, $two]));
```

### Getting values and names

```php
assertTrue(1, $one->value());
assertTrue('Option one', $one->name());
```

Getting all values
```php
var_export(TestIntegerEnum::getAllValues());

//  array (
//    0 => 1,
//    1 => 2,
//  )
```

```php
var_export(TestStringEnum::getAllValues());

//  array (
//    0 => 'one',
//    1 => 'two',
//    2 => 'thirdOption',
//    3 => 'fourthOption',
//  )
```

Getting all names
```php
var_export(TestIntegerEnum::getAllNames());

//  array (
//    1 => 'Option one',
//    2 => '2',
//  )
```

```php
var_export(TestStringEnum::getAllNames());

//  array (
//    'one' => 'Option one',
//    'two' => 'two',
//    'thirdOption' => 'Option three',
//    'fourthOption' => 'fourthOption',
//  )
```

## Caching

Wrap the `SimpleEnumerationParser`, 
set the instance of caching parser to parser factory: `EnumParserFactory::setParser()`
