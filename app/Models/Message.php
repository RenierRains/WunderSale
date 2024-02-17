<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'body',
        // optionally other fields like 'read_at' to track read receipt? mybe
    ];

    /**
     * dates.
     *
     * @var array<string>
     */
    protected $dates = ['deleted_at'];

    /**
     * Get user tht sent message.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    /**
     * Get user that received message.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    // can add methods to mark the message as read or other 
}
