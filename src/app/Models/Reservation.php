<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'shop_id', 'reservation_date', 'reservation_time', 'reservation_number', 'reminder_sent'];

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function users()
    {
        return $this->hasMany(user::class);
    }

    public function shop()
    {
        return $this->belongsTo(shop::class);
    }
}
