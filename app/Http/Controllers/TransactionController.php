<?php

namespace App\Http\Controllers;

use App\Models\SystemPool;
use App\Models\Transaction;
use App\Http\Requests\TransactionReviewRequest;
use App\Http\Requests\TransactionRequestCreation;
use App\Http\Requests\UpdateTransactionRequest;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role === 'checker') {
            return view('transaction.index')->with('user', auth()->user())->with('checker', 'checker')->with('maker', 'maker')->with('rejected', 'rejected')->with('pending', 'pending')->with('transactions', Transaction::all());
        }
        return view('transaction.index')->with('user', auth()->user())->with('checker', 'checker')->with('maker', 'maker')->with('rejected', 'rejected')->with('pending', 'pending');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transaction.create')->with('user', auth()->user())->with('transaction_types', config('data.transaction_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequestCreation $request)
    {
        $request->merge([
            'user_id' => auth()->user()->id,
        ]);
        $transaction = Transaction::create($request->all());
        
        Log::info("A transaction of {$transaction->amount} for {$transaction->user->name} has been created");

        return redirect()->route('transaction');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        if ($transaction->status !== "rejected") {
            Response::deny('Transaction cannot be edited because it is already approved or pending.');
            abort(403, 'Transaction cannot be edited because it is already approved or pending.');
        }

        return view('transaction.edit')->with('user', auth()->user())->with('transaction_types', config('data.transaction_types'))->with('note', $transaction->note)->with('transaction', $transaction);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function review(Transaction $transaction)
    {
        if ( $transaction->status !== "pending") {
            abort(403, 'Transaction cannot be reviewed because it is already approved or rejected.');
            Response::deny('Transaction cannot be reviewed because it is already approved or rejected.');
        }
        return view('transaction.review')->with('user', auth()->user())->with('transaction', $transaction)->with('decisions', ['pending', 'approved', 'rejected']);
    }

    public function decide(TransactionReviewRequest $request, Transaction $transaction)
    {
        // dd($transaction->id);
        DB::beginTransaction();
        $instance = Transaction::find($transaction->id);
        try {
            if($request->status !== 'pending') {
                if($request->status === 'rejected') {
                    $instance->update([
                        'note' => $request->note
                    ]);
                } else {
                    $systemPool = SystemPool::first();
                    if($transaction->type === 'credit'){
                        $transaction->user->wallet->creditBalance($transaction->amount);
                        $systemPool->debitBalance($transaction->amount);
                    } else {
                        $transaction->user->wallet->debitBalance($transaction->amount);
                        $systemPool->creditBalance($transaction->amount);
                    }
                    if ($request->note) {
                        $instance->update([
                            'note' => $request->note
                        ]);
                    }
                }
                $instance->update([
                    'status' => $request->status
                ]);
                Log::alert("Transaction has been {$transaction->status}");
            } else {
                Log::warning("Transaction is still $transaction->status");
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Transaction failed to update: ". $e->getMessage());
        }

        return redirect()->route('transaction');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        if ( $transaction->status !== "rejected") {
            Log::notice("{$transaction->user->name} tried to edit a transaction of status {$transaction->status}");
            abort(403, 'Transaction cannot be edited because it is already approved or pending.');
        }

        $request->merge([
            'status' => 'pending'
        ]);

        $transaction->update($request->all());
        
        Log::alert("Transaction has been updated");

        return redirect()->route('transaction');
    }
}
