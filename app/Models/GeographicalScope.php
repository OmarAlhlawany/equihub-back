<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeographicalScope extends Model {
    use HasFactory;

    protected $fillable = ['name'];

    // Define the relationship with Investor
    public function investors()
    {
        return $this->hasMany(Investor::class, 'geographical_scope_id');
    }

}
