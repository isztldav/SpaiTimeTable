<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpaiLesson extends Model implements \MaddHatter\LaravelFullcalendar\Event
{
    protected $dates = ['start', 'end'];
    /**
     * Get the event's title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->aula." ".$this->docente." ".$this->materia;
    }
    /**
     * Is it an all day event?
     *
     * @return bool
     */
    public function isAllDay()
    {
        return intval($this->is_all_day);
    }
    /**
     * Get the start time
     *
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }
    /**
     * Get the end time
     *
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }
    /**
     * Get the event's ID
     *
     * @return int|string|null
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Optional FullCalendar.io settings for this event
     *
     * @return array
     */
    public function getEventOptions()
    {
        return [
            'color' => "#808080",
        ];
    }
}
