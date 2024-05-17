<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public static function filter($keywords = [], $users = [], $startDate = null, $endDate = null)
    {
        $query = self::query();

        // Filter by keywords
        if (!empty($keywords)) {
            $query->whereIn('message', $keywords);
        }

        // Filter by users
        if (!empty($users)) {
            $query->whereIn('sender_id', $users)
                ->orWhereIn('receiver_id', $users);
        }

        // Filter by date range
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        return $query->get();
    }
}
