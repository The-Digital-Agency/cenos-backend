<?php

namespace App\Http\Controllers\User;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Fetch All Users (includes Admin)
     *
     * @param Request $request
     * @return void
     */
    public function getUsers($onlyAdmins = false)
    {
        $users = User::query();
        $orderColumn = 'created_at';
        // Hide god's eye from list
        $users->where('email', '!=', 'doyin.admin@check-dc.com');

        if ($onlyAdmins) {
            $users->where('role', 'admin');
        }

        // ?search=
        if (request()->has('search')) {
            $search = "%" . request()->search . "%";
            $users->where(function ($q) use ($search) {
                return $q->where('name', 'like', $search)
                    ->orWhere('email', 'like', $search)
                    ->orWhere('phone', 'like', $search)
                    ->orWhere('address', 'like', $search)
                    ->orWhere('address_2', 'like', $search);
            });
        }

        // ?created_at
        if (request()->has('created_at')) {
            $users->whereDate('created_at', request()->created_at);
        }

        // Append Total Spend
        $users->withSum('successOrders', 'billing_total');

        // ?special_date
        if (request()->has('special_date')) {
            $specialDate = Carbon::parse(request()->special_date);
            $users->whereNotNull('special_date')
                ->whereDay('special_date', $specialDate->day)
                ->whereMonth('special_date', $specialDate->month);
            $orderColumn = 'success_orders_sum_billing_total';
        }

        // ?sort_spend
        if (request()->has('sort_spend')) {
            $orderColumn = 'success_orders_sum_billing_total';
        }

        $users = $users->orderBy($orderColumn, 'DESC')->paginate(20);

        return response()->json($users);
    }

    /**
     * Fetch All Admins
     *
     * @return void
     */
    public function getAdmins()
    {
        return $this->getUsers(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'nullable',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }

        $user = User::find($id);
        $user->update($input);

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(null, 204);
    }

    /**
     * Delete User
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteAdmin(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
        return response()->json(['message' => 'User successfully deleted']);
    }

    public function ordersByID($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user->orders, 200);
    }

    public function orders()
    {
        $user = JWTAuth::parseToken()->authenticate();

        // return $user;
        // $user = User::findOrFail($id);
        return response()->json($user->orders(), 200);
        // return response()->json($user->orders->latest(), 200);
    }

    /**
     * Update admin user
     *
     * @param Request $request
     * @return void
     */
    public function updateAdmin(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'nullable|email|unique:users,email,' . $request->id,
            'admin_role' => 'required'
        ])->validate();

        $user = User::find($request->id);

        $user->update($request->all());

        return  response()->json($user, 201);
    }

    public function updatePassword(Request $request)
    {
        $user = User::find($request->id);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = $user->update($input);

        return  response()->json($user, 201);
    }
}
