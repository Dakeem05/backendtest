<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class SystemPool extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function creditBalance(float $amount)
    {
        $this->increment('balance', $amount);
        
        Log::alert("System pool has been credited");
    }

    public function debitBalance(float $amount)
    {
        $this->decrement('balance', $amount);
        
        Log::alert("System pool has been debited");
    }
}
