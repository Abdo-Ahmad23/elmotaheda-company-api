<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
         $portfolios = Portfolio::latest()->get(); 
        
        return response()->json([
            'status' => true,
            'data' => $portfolios
        ], 200);
    }

    public function show($id)
    {
        $portfolio = Portfolio::find($id);

        if (!$portfolio) {
            return response()->json([
                'status' => false,
                'message' => 'this project is not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $portfolio
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $portfolio = Portfolio::find($id);
    
        if (!$portfolio) {
            return response()->json([
                'status' => false,
                'message' => 'العمل غير موجود'
            ], 404);
        }
    
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'service_type' => 'sometimes|string|max:255',
            'image_before' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image_after' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        // =======================
        // title + service_type
        // =======================
        if ($request->has('title')) {
            $portfolio->title = $request->title;
        }
    
        if ($request->has('service_type')) {
            $portfolio->service_type = $request->service_type;
        }
    
        // =======================
        // image_before
        // =======================
        if ($request->hasFile('image_before')) {
    
            // حذف الصورة القديمة
            if ($portfolio->image_before) {
                $oldPath = public_path($portfolio->image_before);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
    
            $file = $request->file('image_before');
            $name = time() . '_before.' . $file->getClientOriginalExtension();
    
            $file->move(public_path('uploads'), $name);
    
            $portfolio->image_before = 'uploads/' . $name;
        }
    
        // =======================
        // image_after
        // =======================
        if ($request->hasFile('image_after')) {
    
            if ($portfolio->image_after) {
                $oldPath = public_path($portfolio->image_after);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
     
            $file = $request->file('image_after');
            $name = time() . '_after.' . $file->getClientOriginalExtension();
    
            $file->move(public_path('uploads'), $name);
    
            $portfolio->image_after = 'uploads/' . $name;
        }
    
        $portfolio->save();
    
        return response()->json([
            'status' => true,
            'message' => 'Update Successful',
            'data' => $portfolio
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'service_type' => 'required|string|max:255',
            'image_before' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'image_after' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        // ======================
        // image_before
        // ======================
        $fileBefore = $request->file('image_before');
    
        $nameBefore = 'before_' . time() . '_' . uniqid() . '.' .
            $fileBefore->getClientOriginalExtension();
    
        $fileBefore->move(public_path('uploads'), $nameBefore);
    
        $imageBeforePath = 'uploads/' . $nameBefore;
    
        // ======================
        // image_after
        // ======================
        $fileAfter = $request->file('image_after');
    
        $nameAfter = 'after_' . time() . '_' . uniqid() . '.' .
            $fileAfter->getClientOriginalExtension();
    
        $fileAfter->move(public_path('uploads'), $nameAfter);
    
        $imageAfterPath = 'uploads/' . $nameAfter;
    
        // ======================
        // save to DB
        // ======================
        $portfolio = Portfolio::create([
            'title' => $request->title,
            'service_type' => $request->service_type,
            'image_before' => $imageBeforePath,
            'image_after' => $imageAfterPath,
        ]);
    
        return response()->json([
            'status' => true,
            'message' => 'created successfully',
            'data' => $portfolio
        ], 201);
    }
    
    public function destroy($id)
    {
        $portfolio = Portfolio::find($id);
    
        if (!$portfolio) {
            return response()->json([
                'status' => false,
                'message' => 'this project is not found'
            ], 404);
        }
    
        // ======================
        // delete image_before
        // ======================
        if ($portfolio->image_before) {
            $pathBefore = public_path($portfolio->image_before);
    
            if (file_exists($pathBefore)) {
                unlink($pathBefore);
            }
        }
    
        // ======================
        // delete image_after
        // ======================
        if ($portfolio->image_after) {
            $pathAfter = public_path($portfolio->image_after);
    
            if (file_exists($pathAfter)) {
                unlink($pathAfter);
            }
        }
    
        // ======================
        // delete record
        // ======================
        $portfolio->delete();
    
        return response()->json([
            'status' => true,
            'message' => 'deleted successfully'
        ], 200);
    }
}
