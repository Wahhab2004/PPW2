<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone_number',
        'email',
        'address',
        'birth_date',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function borrowers(): HasMany
    {
        return $this->hasMany(Borrower::class);
    }
}
