<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'investor_id',
        'response_data'
    ];

    public function investor()
    {
        return $this->belongsTo(Investor::class);
    }
}