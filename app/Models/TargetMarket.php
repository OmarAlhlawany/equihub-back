<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetMarket extends Model {
    use HasFactory;

    protected $fillable = ['name'];
    public function startups()
    {
        return $this->hasMany(Startup::class, 'target_market_id');
    }
}
