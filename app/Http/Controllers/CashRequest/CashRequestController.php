<?php

namespace App\Http\Controllers\CashRequest;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CashRequest;
use Illuminate\Validation\ValidationException;

class CashRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $data = CashRequest::orderBy('id', 'DESC')->paginate(5);
        return  response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'itemRequest' => 'required',
            'amount' => 'required',
            'date_of_expense' => 'required',
            'expense_type' => 'required',
            'approval_type' => 'required',
            'user' => 'required'
        ]);

        $request->request->add(['status' => 'processing']);

        $cashRequest = CashRequest::create($request->all());

        return  response()->json($cashRequest, 201);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function status(Request $request, $id)
    {
        $status = CashRequest::find($id);
        $input = $request->all();
        $status->update($input);

        return response()->json($status, 200);
    }

    /**
     * Change the status of the cash request
     *
     * @param Request $request
     * @return void
     */
    public function changeStatus(Request $request)
    {
        $cashRequest = CashRequest::find($request->id);
        $cashRequest->status = $request->status;
        $cashRequest->save();

        return $cashRequest;
    }
}
