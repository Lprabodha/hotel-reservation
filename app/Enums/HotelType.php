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
            self::LUXURY => 'Luxury Hotel',
            self::BOUTIQUE => 'Boutique Hotel',
            self::BUDGET => 'Budget Hotel',
            self::BUSINESS => 'Business Hotel',
            self::RESORT => 'Resort Hotel',
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
