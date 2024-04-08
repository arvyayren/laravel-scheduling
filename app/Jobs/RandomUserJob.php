<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

use App\Models\User;

class RandomUserJob implements ShouldQueue
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
        //connection to https to get data
        $client = new \GuzzleHttp\Client();
        $request = $client->get('https://randomuser.me/api/?results=20');  $response = $request->getBody()->getContents();
        $users = json_decode($response, true);
        //connection to https to get data

        //store data user
        $user_collect = collect($users['results']);

        $insert_function = $user_collect->map(function ($function){
            $insert = User::updateOrCreate(
                [
                    'uuid' => $function['login']['uuid']
                ],
                [
                    'uuid' => $function['login']['uuid'],
                    'Gender' => $function['gender'],
                    'Name' => json_encode($function['name']),
                    'Location' => json_encode($function['location']),
                    'age' => $function['dob']['age']
                ]
            );

            return $function['gender'];
        });

        $genders = array_count_values($insert_function->toArray());
        //store data user

        //store to redis
        $redis = Redis::connection();

        $redis->set('male', $redis->get('male') + $genders['male']);
        $redis->set('female', $redis->get('female') + $genders['female']);
        //store to redis
    }
}
