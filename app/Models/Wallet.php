<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class Wallet extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function creditBalance(float $amount)
    {
        $this->increment('balance', $amount);
        
        Log::alert("User {$this->user->name} Wallet has been credited");
    }

    public function debitBalance(float $amount)
    {
        $this->decrement('balance', $amount);
        
        Log::alert("User {$this->user->name} Wallet has been debited");
    }
}
