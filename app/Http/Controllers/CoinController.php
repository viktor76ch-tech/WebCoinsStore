<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    public function index(Request $request)
    {
        $query = Coin::query()
            ->with('category')
            ->orderByDesc('created_at');

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        }

        if ($request->filled('country')) {
            $query->where('country', $request->input('country'));
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->input('condition'));
        }

        if ($request->filled('year_from')) {
            $query->where('year', '>=', (int) $request->input('year_from'));
        }

        if ($request->filled('year_to')) {
            $query->where('year', '<=', (int) $request->input('year_to'));
        }

        if ($request->filled('search')) {
            $term = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                    ->orWhere('description', 'like', $term);
            });
        }

        $coins = $query->paginate(12)->withQueryString();

        $countries = Coin::query()
            ->select('country')->distinct()->orderBy('country')->pluck('country');

        $conditions = Coin::query()
            ->select('condition')->distinct()->orderBy('condition')->pluck('condition');

        $categories = \App\Models\Category::orderBy('sort_order')->get();

        $currentCategory = $request->filled('category')
            ? $categories->firstWhere('slug', $request->input('category'))
            : null;

        return view('coins.index', compact(
            'coins', 'countries', 'conditions', 'categories', 'currentCategory'
        ));
    }

    public function show(Coin $coin)
    {
        return view('coins.show', compact('coin'));
    }
}
