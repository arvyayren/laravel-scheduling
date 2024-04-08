<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

use App\Models\DailyRecord;
use App\Models\User;

class DailyRecordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $redis = Redis::connection();

        //get count from redis
        $male_count = $redis->get('male');
        $female_count = $redis->get('female');
        //get count from redis
        
        //get avg age
        $date = date("Y-m-d");
        $yesterday = date("Y-m-d", strtotime("-1 day"));

        $males_age = User::where('Gender', 'male')
        ->whereDate('created_at', '=', $yesterday)
        ->pluck('age')->toArray();

        $females_age = User::where('Gender', 'female')
        ->whereDate('created_at', '=', $yesterday)
        ->pluck('age')->toArray();

        $males_age = count($males_age) > 0 ? array_sum($males_age) / count($males_age) : 0;
        $females_age = count($females_age) > 0 ? array_sum($females_age) / count($females_age) : 0;
        //get avg age

        DailyRecord::create([
            'date' => $date,
            'male_count' => $male_count,
            'female_count' => $female_count,
            'male_avg_age' => $males_age,
            'female_avg_age' => $females_age
        ]);

        $redis->del('male');
        $redis->del('female');
    }
}
