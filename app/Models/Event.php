<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable=['name','start_time','end_time','user_id'];

    public function attendees(){
        return $this->hasMany(Attendee::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
