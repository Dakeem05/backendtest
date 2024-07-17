<?php

namespace Tests\Feature;

use App\Http\Controllers\WalletController;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;

uses(RefreshDatabase::class);

it('Authenticated user dashboard view', function () {
    $user = User::factory()->create();
    $user->wallet()->save((new Wallet));
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));

    $response->assertStatus(200)
             ->assertViewIs('dashboard')
             ->assertViewHas('user', $user);
});