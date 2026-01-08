<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Medication::query()->where('stok', '>', 0);
        
        // Filter by category if provided
        if ($request->has('category') && $request->category != 'all') {
            $query->where('kategori', $request->category);
        }

        // Search
        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $medications = $query->paginate(12);
        
        // Get unique categories for filter
        $categories = Medication::select('kategori')->distinct()->pluck('kategori');

        return view('shop.index', compact('medications', 'categories'));
    }

    public function show(Medication $medication)
    {
        return view('shop.show', compact('medication'));
    }
}
