<?php


namespace App\Http\Controllers\Transaction;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller
{

    public function index()
    {
        $data = Transaction::paginate();
        return response()->json($data, 200);
    }

    public function show($id)
    {
        $data = Transaction::findOrFail($id);
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required|exists:App\Order,id',
            'transaction_ref' => 'required|uuid',
            'amount' => 'required|numeric',
            'payment_ref' => 'nullable|string',
            'channel' => 'required|string',
            'status' => 'nullable|string'
        ]);

        $tx = Transaction::create($request->all());
        return response()->json($tx, 201);
    }

    public function authenticateMonnify()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode("MK_TEST_SAF7HR5F3F:4SY6TNL8CK3VPRSBTHTRG2N8XXEGC6NL")
        ])->post('https://sandbox.monnify.com/api/v1/auth/login/');

        return $response->json();
    }

    public function fetchMonnify(Request $request)
    {
        $response = Http::withToken($request->token)
            ->get('https://sandbox.monnify.com/api/v1/transactions/search?page=' . $request->page . '&size=50');

        return response()->json($response->json(), $response->status());
    }

    public function fetchPaystack(Request $request)
    {
        $response = Http::withToken(config('paystack.secretkey'))
            ->get('https://api.paystack.co/transaction?page=' . $request->page . '&perPage=50');

        return response()->json($response->json(), $response->status());
    }
}
