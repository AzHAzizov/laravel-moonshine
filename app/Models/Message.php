<?php

namespace App\Models;

use App\Casts\UnserializeCaster;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'body', 'text'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'body' => UnserializeCaster::class,
    ];



    public function user() {
        return $this->belongsTo(User::class);
    }
}
