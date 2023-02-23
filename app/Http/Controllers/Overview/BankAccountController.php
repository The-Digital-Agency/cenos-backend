<?php

namespace App\Http\Controllers\Overview;

use App\BankAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bankAccount = BankAccount::orderBy('created_at', 'DESC')->get();

        return response()->json($bankAccount, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_name' => 'required|string|unique:bank_accounts',
            'account_number' => 'nullable|unique:bank_accounts',
            'bank_name' => 'required|unique:bank_accounts',
            'status' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $request['author_id'] = Auth::id();

        $newBankAccount = BankAccount::create($request->all());

        return response()->json($newBankAccount, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_name' => 'required|string|unique:bank_accounts,account_name,' . $request->id,
            'account_number' => 'nullable|unique:bank_accounts,account_number,' . $request->id,
            'bank_name' => 'required|unique:bank_accounts,bank_name,' . $request->id,
            'status' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $updatedBankAccount = BankAccount::find($request->id)->update([
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'status' => $request->status
        ]);

        return response()->json($updatedBankAccount, 204);
    }

    public function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_name' => 'required|string|unique:bank_accounts',
            'account_number' => 'nullable|unique:bank_accounts',
            'bank_name' => 'required|unique:bank_accounts',
            'status' => 'required|string'
        ]);

        return $validator;
    }
}
