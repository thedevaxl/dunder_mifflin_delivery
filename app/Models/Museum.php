<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Museum extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lat',
        'long',
        'region',
        'province',
        'municipality',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'lat' => 'float',
        'long' => 'float',
    ];

    /**
     * Get the full address of the museum.
     *
     * @return string
     */
    public function getAddressAttribute(): string
    {
        return "{$this->municipality}, {$this->province}, {$this->region}";
    }

    /**
     * The factory definition for this model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\MuseumFactory::new();
    }
}
