<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function cart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'qty' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();

            $user = User::find($request->user_id);

            $user->products()->syncWithPivotValues($request->product_id, ['qty' => $request->qty]);

            DB::commit();

            return response()->json([
                'status' => 'success'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
    }

    public function mycart(User $user)
    {
        try {
            return response()->json([
                'status' => 'success',
                'products' => $user->products
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
    }
}
