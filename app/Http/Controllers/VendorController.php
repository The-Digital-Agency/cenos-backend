<?php

namespace App\Http\Controllers;

use Validator;
use App\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Fetch Vendors
     *
     * @return void
     */
    public function getVendors()
    {
        $vendors = Vendor::latest()->get(['id', 'name']);
        return response()->json($vendors, 200);
    }

    /**
     * Fetch All Vendors
     *
     * @return void
     */
    public function getAllVendors()
    {
        $vendors = Vendor::latest()->paginate(20);
        return response()->json($vendors, 200);
    }

    /**
     * Store Vendor
     *
     * @param Request $request
     * @return void
     */
    public function storeVendors(Request $request)
    {
        // Validator::make($request->all(), [
        //     'name' => ['required'],
        // ])->validate();

        $vendor = Vendor::create($request->all());

        return response()->json($vendor, 200);
    }
}
