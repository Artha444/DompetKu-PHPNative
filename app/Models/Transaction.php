<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'date',
        'description',
        'type',
    ];

    protected $casts = [
        'date' => 'date',
    ];
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
