<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'start_date', 'end_date', 'status', 'branch','is_active',
        'in_charge', 'term','event_week', 'term'
    ];



    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'class_event', 'event_id', 'class_id');
    }

}
