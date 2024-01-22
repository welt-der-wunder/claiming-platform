<?php

namespace App\Traits;

use Carbon\Carbon;
use JamesMills\LaravelTimezone\Facades\Timezone;

trait FormattedTimestamps
{
    public static string $FORMAT = 'Y-m-d\TH:i:s\Z';

    public function getCasts(): array
    {
        $casts = parent::getCasts();

        if (method_exists($this, 'getTranslatableAttributes')) {
            $casts = array_merge($casts, array_fill_keys($this->getTranslatableAttributes(), 'array'));
        }

        return array_merge($casts, [
            'created_at' => 'datetime:'.self::getFormat(),
            'updated_at' => 'datetime:'.self::getFormat(),
        ]);
    }

    public function getDateAttributeInLocalTimezone(string $value)
    {
        return $this->changeTimezone($value);
    }

    public function convertDateAttributeToLocalTimezone(Carbon $date): string
    {
        return Timezone::convertToLocal($date, self::getFormat());
    }

    public function __get($key)
    {
        $casts = $this->getCasts();
        $dateCasts = [];
        foreach ($casts as $attribute => $cast) {
            if (strpos($cast, 'datetime') !== false) {
                $dateCasts[] = $attribute;
            }
        }

        $attributeValue = $this->getAttribute($key);

        return $attributeValue;
        // date variable
        if (in_array($key, $dateCasts) && $attributeValue != null) {
            return $this->changeTimezone($attributeValue);
        }

        return $attributeValue;
    }

    public static function getFormat(): string
    {
        if (property_exists(self::class, 'MODEL_TIME_FORMAT')) {
            return self::$MODEL_TIME_FORMAT;
        }

        return self::$FORMAT;
    }

    private function changeTimezone(string $value): string
    {
        $date = new Carbon($value);

        return $this->convertDateAttributeToLocalTimezone($date);
    }
}
