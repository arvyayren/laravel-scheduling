<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'male_count', 'female_count', 'male_avg_age', 'female_avg_age'
    ];

    protected static function booted(): void
    {
        static::updated(function ($daily_record) {
            if($daily_record->male_count != $daily_record->getOriginal('male_count')){
                $males_age = User::where('Gender', 'male')
                ->whereDate('created_at', '=', $daily_record->date)
                ->pluck('age')->toArray();

                $males_age = count($males_age) > 0 ? array_sum($males_age) / count($males_age) : 0;

                DailyRecord::where('id', $daily_record->id)->update(['male_avg_age' => $males_age]);
            }

            if($daily_record->female_count != $daily_record->getOriginal('female_count')){
                $females_age = User::where('Gender', 'female')
                ->whereDate('created_at', '=', $daily_record->date)
                ->pluck('age')->toArray();

                $females_age = count($females_age) > 0 ? array_sum($females_age) / count($females_age) : 0;

                DailyRecord::where('id', $daily_record->id)->update(['female_avg_age' => $females_age]);
            }
        });
    }
}
