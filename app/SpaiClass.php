<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpaiClass extends Model
{
    public function getId()
    {
        return $this->id;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getCategory()
    {
        return $this->category;
    }
}
