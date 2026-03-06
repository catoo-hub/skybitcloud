<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'cpu',
        'ram_gb',
        'disk_gb',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'price' => 'integer',
            'cpu' => 'integer',
            'ram_gb' => 'integer',
            'disk_gb' => 'integer',
        ];
    }

    public function serverPurchases(): HasMany
    {
        return $this->hasMany(ServerPurchase::class);
    }
}
