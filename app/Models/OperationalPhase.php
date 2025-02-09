<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationalPhase extends Model {
    use HasFactory;

    protected $fillable = ['name'];

    // Define the relationship with Startup
    public function startups()
    {
        return $this->hasMany(Startup::class, 'operational_phase_id');
    }

}
