<?php

namespace App\Http\Controllers\Packages;

use App\Package;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class PackageController extends Controller
{
    /**
     * Grabs the needed object values and keys
     *
     * @param Object $content
     * @return JsonResponse
     */
    public function generateContent($content)
    {
        $generateObject = [];
        if ($content) {
            foreach ($content as $value) {
                $generateObject[$value['id']] = $value['quantity'];
            }
        }

        return json_encode($generateObject);
    }

    /**
     * Upload product image to Cloudinary
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadImage(Request $request, $oldURL = '')
    {
        if ($request->file) {
            $response = Http::post('https://api.cloudinary.com/v1_1/dcjpsgzq1/image/upload', [
                'file' => $request->file,
                'upload_preset' => $request->upload_preset
            ]);

            return $response;
        }

        return ['url' => $oldURL];
    }

    /**
     * Upload featured image to Cloudinary
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadFeaturedImage(Request $request, $oldURL = '')
    {
        if ($request->featuredFile) {
            $response = Http::post('https://api.cloudinary.com/v1_1/dcjpsgzq1/image/upload', [
                'file' => $request->featuredFile,
                'upload_preset' => $request->upload_preset
            ]);

            return $response;
        }

        return ['url' => $oldURL];
    }

    /**
     * Fetch Packages
     *
     * @return JsonResponse
     */
    public function getPackages()
    {
        $packages = Package::orderBy('price', 'ASC')
            ->where('id', '!=', '45') // Avoid custom product
            ->where('status', 'active')->get();

        return response()->json($packages, 200);
    }

    /**
     * Fetch All Packages for Admin
     *
     * @return JsonResponse
     */
    public function getAllPackages()
    {
        $packages = Package::orderBy('price', 'ASC')
            ->orderBy('status', 'DESC')->get();

        return response()->json($packages, 200);
    }

    /**
     * Fetch All Packages Regardless of the Type
     *
     * @return JsonResponse
     */
    public function getCustomPack()
    {
        $customPackage = Package::find(45);
        return response()->json($customPackage, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $data = Package::findOrFail($id);
        return response()->json($data, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        // Upload product image
        $imageResponse = $this->uploadImage($request);

        // Upload featured image
        $imageResponseFeatured = $this->uploadFeaturedImage($request);

        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'price' => 'required|numeric'
        ]);

        // return $this->generateContent($request->content);

        $package = Package::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'price' => $request->price,
            'sku' => Str::orderedUuid(),
            'content' => $this->generateContent($request->content),
            'product_image' => $imageResponse['url'],
            'featured_image' => $imageResponseFeatured['url'],
        ]);

        return response()->json($package, 201);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        // Upload product image
        $imageResponse = $this->uploadImage($request, $package->product_image);

        // Upload featured image
        $imageResponseFeatured = $this->uploadFeaturedImage($request, $package->featured_image);

        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'price' => 'required|numeric'
        ]);

        // return $this->generateContent($request->content);

        $package->update([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'price' => $request->price,
            'content' => $this->generateContent($request->content),
            'product_image' => $imageResponse['url'],
            'featured_image' => $imageResponseFeatured['url'],
        ]);

        return response()->json($package, 201);
    }

    /**
     * Update Status
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateStatus(Request $request)
    {
        $package = Package::findOrFail($request->id);

        $package->status = $request->status;
        $package->save();

        return response()->json($package, 201);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return response()->json(null, 204);
    }
}
