<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['title', 'content', 'category', 'link', 'type_link', 'date', 'hour', 'success', 'failure'];
    protected $labels = ['title' => 'Título',
                        'content' => 'Conteúdo',
                        'category' => 'Categoria',
                        'link' => 'Link',
                        'type_link' => 'Tipo de link',
                        'date' => 'Data',
                        'success' => 'Sucesso',
                        'failure' => 'Falhou',
                        'hour' => 'Hora'];

    public function getLabels() 
    {
        return $this->labels;
    }

    public function getNotificationHasFcm()
    {
        return $this->hasMany(NotificationHasFcm::class, 'notification_id', 'id');
    }

    public function getCategory()
    {
        if ($this->category == 'A') {
            return 'Anúncios';
        } else {
            return 'Notícias';
        } 
    }

    public function getTypeLink()
    {
        if ($this->type_link == 'E') {
            return 'Externo';
        } else {
            return 'Interno';
        }
    }

    public function getDateHour()
    {
        $date = new Carbon($this->date);
        $hour = new Carbon($this->hour);
        
        return $date->format('d/m/Y') . " " . $hour->format('H:i');
        
    }

    public function getDate()
    {
        $date = new Carbon($this->date);
        return $date->format('d/m/Y');
    }

    public function getHour()
    {
        if ($this->hour) {
            $hour = new Carbon($this->hour);
            return $hour->format('H:i');
        }

        return null;
    }
}
