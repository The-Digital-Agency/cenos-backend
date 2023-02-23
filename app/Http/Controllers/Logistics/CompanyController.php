<?php

namespace App\Http\Controllers\Logistics;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = Company::select('*')->orderBy('id', 'DESC')->get();
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
        $company = Company::create($request->all());
        return  response()->json($company, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $company = Company::findOrFail($id);
        return  response()->json($company, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request)
    {
        $company = Company::findOrFail($request->id);
        $company->update($request->all());

        return response()->json($company, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json(null, 204);
    }

    /**
     * Return all orders fulfilled by delivery company
     *
     * @param $id
     * @return JsonResponse
     */
    public function orders($id)
    {
        $company = Company::findOrFail($id);

        return response()->json($company->orders, 200);
    }
}
