<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentType extends Model {
    use HasFactory;

    protected $fillable = ['name'];

        // Define the relationship
        public function investors()
        {
            return $this->hasMany(Investor::class, 'investment_type_id');
        }
    
}
