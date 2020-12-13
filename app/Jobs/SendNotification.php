<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\User;
use App\Models\UserDeviceToken;
use Edujugon\PushNotification\PushNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Session;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sendToAllUsers;

    protected $recievers;

    protected $title;

    protected $body;

    protected $pushMessage;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->sendToAllUsers = $data['scope'] == 'all' ? true : false;
        $this->recievers      = isset($data['users']) ? $data['users'] : [];
        $this->title          = $data['title'];
        $this->body           = $data['body'];

        $this->pushMessage = new PushNotification('fcm');
        $this->pushMessage->setMessage([
            'notification' => [
                'title' => $this->title,
                'body'  => $this->body,
            ],
        ])
            ->setApiKey(config('pushnotification.fcm.apiKey'))
            ->setConfig(['dry_run' => false]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendToAllUsers ? $this->sendToAllUsers() : $this->sendToSelectedUsers();

        $this->deleteUnregisteredDeviceTokens($this->pushMessage->getUnregisteredDeviceTokens());
    }

    public function sendToSelectedUsers()
    {
        $users = User::whereIn('uuid', $this->recievers)
            ->with('deviceTokens')
            ->get();

        $devicesTokens = $users
            ->pluck('deviceTokens')
            ->flatten()
            ->toArray();

        $this->pushMessage
            ->setDevicesToken(array_column($devicesTokens, 'device_token'))
            ->send();

        if ($this->pushMessage->getFeedback()->success) {
            Notification::create([
                'title'   => $this->title,
                'body'    => $this->body,
                'sent_at' => now(),
                'users'   => $users->pluck('id')->toArray(),
            ]);

            flash(__('messages.notification.sent'));
        } else {
            flash(__('messages.notification.not_sent'), 'danger');
        }
    }

    public function sendToAllUsers()
    {
        $this->pushMessage->sendByTopic('general');

        if (isset($this->pushMessage->getFeedback()->success) && $this->pushMessage->getFeedback()->success) {
            Notification::create([
                'title'       => $this->title,
                'body'        => $this->body,
                'sent_at'     => now(),
                'sent_to_all' => true,
            ]);
            flash(__('messages.notification.sent'));
        } else {
            flash(__('messages.notification.not_sent'), 'danger');
        }
    }

    public function deleteUnregisteredDeviceTokens($unregisteredDeviceTokens)
    {
        array_walk($unregisteredDeviceTokens, function ($token) {
            UserDeviceToken::where('device_token', $token)->first()->delete();
        });
    }
}
