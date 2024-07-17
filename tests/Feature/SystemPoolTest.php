<?php

namespace Tests\Feature;

use App\Models\SystemPool;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

uses(RefreshDatabase::class);

it('Credits balance', function() {
    $systemPool = SystemPool::create([
        'balance' => config('data.system_pool')
    ]);

    $systemPool->creditBalance(250.00);

    $this->assertEquals(50250.00, $systemPool->refresh()->balance);
});

it('Debits balance', function() {
    $systemPool = SystemPool::create([
        'balance' => config('data.system_pool')
    ]);

    $systemPool->debitBalance(250.00);

    $this->assertEquals(49750.00, $systemPool->refresh()->balance);
});
