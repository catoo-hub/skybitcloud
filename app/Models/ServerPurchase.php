<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServerPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'status',
        'power_state',
        'server_name',
        'os',
        'preset_software',
        'ip_address',
        'port',
        'username',
        'password',
        'expires_at',
        'last_reinstalled_at',
    ];

    protected function casts(): array
    {
        return [
            'port' => 'integer',
            'expires_at' => 'datetime',
            'last_reinstalled_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
