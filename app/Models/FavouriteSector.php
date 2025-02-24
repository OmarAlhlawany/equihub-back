<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavouriteSector extends Model {
    use HasFactory;

    protected $fillable = ['name'];

    public function investors() {
        return $this->belongsToMany(Investor::class, 'investor_favourite_sector');
    }
}
