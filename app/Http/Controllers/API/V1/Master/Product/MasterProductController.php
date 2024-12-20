<?php

namespace App\Http\Controllers\API\V1\Master\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Product\StoreMasterProductRequest;
use App\Http\Requests\Master\Product\UpdateMasterProductRequest;
use App\Http\Resources\Master\Product\MasterProductCollection;
use App\Http\Resources\Master\Product\MasterProductResource;
use App\Models\Master\MasterProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Models\Audit;

class MasterProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = MasterProduct::with(['group'])->orderBy('codeProduct', 'asc');

        if (request('nameProduct')) {
            $query->where("nameProduct", "like", "%" . request("nameProduct") . "%");
        }

        $products = $query->paginate(10);
        // dd($products);
        // $customPaginate = MyServices::customPaginate($articles);

        if ($products->isEmpty()) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Products  Empty'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return new MasterProductCollection($products);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMasterProductRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        // dd($data);
        try {
            $product = MasterProduct::withTrashed()->where('codeProduct', $request->codeProduct)->first();

            if ($product) {
                $product->restore();
                $product->update($request->validated());

                return response()->json([
                    'status' => Response::HTTP_OK,
                    'message' => 'Data restored to dbd'
                ], Response::HTTP_OK);
            }
            // akhir penerapan soft delete
            MasterProduct::create($data);

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Data stored to dbd'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error storing data :' . $e->getMessage());
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed Data stored to dbd'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $masterProduct = MasterProduct::with('group')->findOrFail($id);
        // dd($masterProduct);

        return response()->json([
            'data' => new MasterProductResource($masterProduct),
            'status' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterProduct $masterProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterProductRequest $request, $id)
    {
        $masterProduct = MasterProduct::with('group')->findOrFail($id);
        $masterProduct['updated_by'] = Auth::id();
        $origin = clone $masterProduct;
        // dd($masterProduct);
        // 
        $masterProduct->update($request->validated());

        try {
            return response()->json([
                'data' => new MasterProductResource($masterProduct),
                'message' => "Raw material type with name '$origin->nameProduct' has been changed  '$masterProduct->nameProduct'",
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error updated data :' . $e->getMessage());
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed Data updated to dbd'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = MasterProduct::find($id);
        $origin = clone $product;

        // $exists = MasterProduct::where('codeProduct', $id)->exists();
        // dd($exists);
        // if ($exists) {
        //     return response()->json([
        //         'message' => "Code Product  type cannot be deleted because it is linked to a product",
        //         'status' => Response::HTTP_FORBIDDEN
        //     ], Response::HTTP_FORBIDDEN);
        // }

        $product->delete();

        try {
            return response()->json([
                'message' => "Product  with name '$origin->nameProduct' has been deleted",
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error updated data :' . $e->getMessage());
            return response()->json([
                'message' => "Failed Data deleted",
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logs(Request $request)
    {
        $logs = Audit::where('auditable_type', MasterProduct::class)->get();

        if (request('event')) {
            if (request('event') !== 'created' && request('event') !== 'restored' && request('event') !== 'updated' && request('event') !== 'deleted') {
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => 'The sent method is not correct'
                ], Response::HTTP_NOT_FOUND);
            }

            $logs = Audit::where('auditable_type', MasterProduct::class)->where('event', request('event'))->get();
        }

        // Format data log untuk response
        $data = $logs->map(function ($log) {
            return [
                // 'id' => $log->id,
                'event' => $log->event,
                'old_values' => $log->old_values,
                'new_values' => $log->new_values,
                'user_id' => $log->user_id,
                'user_name' => optional($log->user)->name, // Ambil nama user
                'created_at' => $log->created_at,
            ];
        });

        // Return dalam bentuk JSON
        return response()->json([
            'success' => true,
            'logs' => $data,
        ]);
    }
}
