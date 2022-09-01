<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationHasFcm extends Model
{
    public $timestamps = false;
    protected $fillable = ['fcm_id', 'notification_id', 'visualized'];
    protected $labels = ['fcm_id' => 'FCM', 'notification_id' => 'Notificação', 'visualized' => 'Visualização'];

    public function getFcm()
    {
        return $this->hasOne(Fcm::class, 'id', 'fcm_id');
    }

    public function getNotification()
    {
        return $this->hasOne(Notification::class, 'id', 'notification_id');
    }
}
