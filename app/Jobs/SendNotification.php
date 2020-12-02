<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\UserDeviceToken;
use Edujugon\PushNotification\PushNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $recievers;

    protected $title;

    protected $body;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->recievers = $data['users'];
        $this->title = $data['title'];
        $this->body = $data['body'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $push = new PushNotification('fcm');

        $devicesTokens = User::whereIn('uuid', $this->recievers)
            ->with('deviceTokens')
            ->get()
            ->pluck('deviceTokens')
            ->flatten()
            ->toArray();

        $push->setMessage([
            'notification' => [
                'title' => $this->title,
                'body'  => $this->body,
            ],
        ])
            ->setApiKey(config('pushnotification.fcm.apiKey'))
            ->setConfig(['dry_run' => false])
            ->setDevicesToken(array_column($devicesTokens, 'device_token'))
            ->send();

        $unregisteredDeviceTokens = $push->getUnregisteredDeviceTokens();

        array_walk($unregisteredDeviceTokens, function ($token) {
            UserDeviceToken::where('device_token', $token)->first()->delete();
        });
    }
}
