<?php

namespace App\Enums;

enum HotelType:string
{
    case LUXURY = 'luxury';
    case BOUTIQUE = 'boutique';
    case BUDGET = 'budget';
    case BUSINESS = 'business';
    case RESORT = 'resort';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::LUXURY => 'Luxury',
            self::BOUTIQUE => 'Boutique',
            self::BUDGET => 'Budget',
            self::BUSINESS => 'Business',
            self::RESORT => 'Resort',
        };
    }

    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }
        return $options;
    }
}
