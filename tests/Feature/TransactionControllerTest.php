<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

uses(RefreshDatabase::class);

it('Marker transaction index', function () {
    $user = User::factory()->create();
    $user->wallet()->save((new Wallet));
    $this->actingAs($user);

    $response = $this->get(route('transaction'));

    $response->assertStatus(200)
             ->assertViewIs('transaction.index')
             ->assertViewHas('user', $user)
             ->assertViewHas('checker','checker')
             ->assertViewHas('maker', 'maker')
             ->assertViewHas('rejected', 'rejected')
             ->assertViewHas('pending', 'pending');
});

it('Checker transaction index', function () {
    $user = User::factory()->create();
    $user->wallet()->save((new Wallet));
    $transaction = Transaction::create([
        'amount' => 500.00,
        'type' => 'credit',
        'description' => 'Test create a transaction of 500.00 credit',
        'user_id' => $user->id,
    ]);

    $user2 = User::factory()->create(['role' => 'checker']);
    $user2->wallet()->save((new Wallet));
    $this->actingAs($user2);

    $response = $this->get(route('transaction'));

    $response->assertStatus(200)
             ->assertViewIs('transaction.index')
             ->assertViewHas('transactions', Transaction::all())
             ->assertViewHas('user', $user2)
             ->assertViewHas('checker','checker')
             ->assertViewHas('maker', 'maker')
             ->assertViewHas('rejected', 'rejected')
             ->assertViewHas('pending', 'pending');
});

it('Authenticated user transaction view', function () {
    $user = User::factory()->create();
    $user->wallet()->save((new Wallet));
    $this->actingAs($user);

    $response = $this->get(route('transaction.create'));

    $response->assertStatus(200)
             ->assertViewIs('transaction.create')
             ->assertViewHas('user', $user)
             ->assertViewHas('transaction_types', config('data.transaction_types'));
});

it('Create new transaction', function () {
    $user = User::factory()->create();
    $user->wallet()->save((new Wallet));
    $this->actingAs($user);

    $response = $this->post(route('transaction.store'), [
        'amount' => 500.00,
        'type' => 'credit',
        'description' => 'Test create a transaction of 500.00 credit',
        'user_id' => $user->id,
    ]);
    
    // $response->assertOk();
    $this->assertDatabaseHas('transactions', [
        'user_id' => $user->id,
    ]);
    $response->assertRedirect(route('transaction'));
});

it('Edit transaction view for maker', function () {
    $user = User::factory()->create();
    $user->wallet()->save((new Wallet));
    $transaction = Transaction::create([
        'amount' => 500.00,
        'type' => 'credit',
        'description' => 'Test create a transaction of 500.00 credit',
        'user_id' => $user->id,
    ]);

    $user2 = User::factory()->create(['role' => 'checker']);
    $user2->wallet()->save((new Wallet));
    $this->actingAs($user2);

    $response = $this->post(route('transaction.review', $transaction), [
        'status' => 'rejected',
        'note' => 'Rejected',
    ]);
    
    $this->actingAs($user);

    $response = $this->get(route('transaction.edit', $transaction));

    $response->assertStatus(200)
             ->assertViewIs('transaction.edit')
             ->assertViewHas('user', $user)
             ->assertViewHas('transaction_types', config('data.transaction_types'))
             ->assertViewHas('note', $transaction->note)
             ->assertViewHas('transaction', $transaction);
});

it('Doesn\'t display edit view', function () {
    $user = User::factory()->create();
    $user->wallet()->save((new Wallet));
    $transaction = Transaction::create([
        'amount' => 500.00,
        'type' => 'credit',
        'description' => 'Test create a transaction of 500.00 credit',
        'user_id' => $user->id,
    ]);
    $this->actingAs($user);

    $response = $this->get(route('transaction.edit', $transaction));

    $response->assertStatus(403);
});

it('Review transaction view for checker', function () {
    $user = User::factory()->create();
    $user->wallet()->save((new Wallet));
    $transaction = Transaction::create([
        'amount' => 500.00,
        'type' => 'credit',
        'description' => 'Test create a transaction of 500.00 credit',
        'user_id' => $user->id,
    ]);
    
    $user2 = User::factory()->create(['role' => 'checker']);
    $user2->wallet()->save((new Wallet));
    $this->actingAs($user2);

    $response = $this->get(route('transaction.review', $transaction));

    $response->assertStatus(200)
             ->assertViewIs('transaction.review')
             ->assertViewHas('user', $user2)
             ->assertViewHas('transaction', $transaction)
             ->assertViewHas('decisions', ['pending', 'approved', 'rejected']);
});

it('Doesn\'t display review view', function () {
    $user = User::factory()->create();
    $user->wallet()->save((new Wallet));
    $transaction = Transaction::create([
        'amount' => 100.00,
        'type' => 'Credit',
        'description' => 'Test create a transaction of 100.0 credit',
        'user_id' => $user->id,
    ]);
    $this->actingAs($user);

    $response = $this->get(route('transaction.review', $transaction));

    $response->assertStatus(403);
});

it('Decides transaction for authorized user', function() {
    $user = User::factory()->create();
    $user->wallet()->save((new Wallet));
    $transaction = Transaction::create([
        'amount' => 500.00,
        'type' => 'credit',
        'description' => 'Test create a transaction of 500.00 credit',
        'user_id' => $user->id,
    ]);

    $user2 = User::factory()->create(['role' => 'checker']);
    $user2->wallet()->save((new Wallet));
    $this->actingAs($user2);

    $response = $this->post(route('transaction.review', $transaction), [
        'status' => 'rejected',
        'note' => 'Rejected',
    ]);
    
    $response->assertRedirect(route('transaction'));

});

it('Doesn\'t decide transaction', function() {
    $user = User::factory()->create();
    $user->wallet()->save((new Wallet));
    $transaction = Transaction::create([
        'amount' => 500.00,
        'type' => 'credit',
        'description' => 'Test create a transaction of 500.0 credit',
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);
    
    $response = $this->post(route('transaction.review', $transaction), [
        'status' => 'rejected',
        'note' => 'Rejected',
    ]);

    $response->assertStatus(403);
});

it('Update transaction for authorized user', function () {
    $user = User::factory()->create();
    $user->wallet()->save((new Wallet));
    $transaction = Transaction::create([
        'amount' => 500.00,
        'type' => 'credit',
        'description' => 'Test create a transaction of 500.00 credit',
        'user_id' => $user->id,
    ]);

    $user2 = User::factory()->create(['role' => 'checker']);
    $user2->wallet()->save((new Wallet));
    $this->actingAs($user2);

    $response = $this->post(route('transaction.review', $transaction), [
        'status' => 'rejected',
        'note' => 'Rejected',
    ]);
    
    $this->actingAs($user);

    $response = $this->post(route('transaction.update', $transaction), [
        'amount' => 710.00,
        'type' => 'Debit',
        'description' => 'Updated description',
    ]);

    $response->assertRedirect(route('transaction'));
});

it('Doesn\'t update transaction', function () {
    $user = User::factory()->create();
    $user->wallet()->save((new Wallet));
    $transaction = Transaction::create([
        'amount' => 500.00,
        'type' => 'credit',
        'description' => 'Test create a transaction of 500.00 credit',
        'user_id' => $user->id,
    ]);
    $this->actingAs($user);

    $response = $this->post(route('transaction.update', $transaction), [
        'amount' => 150.00,
        'type' => 'Debit',
        'description' => 'Updated description',
    ]);

    $response->assertStatus(403);
});
