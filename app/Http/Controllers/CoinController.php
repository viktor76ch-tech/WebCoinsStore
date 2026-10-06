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
            $category = \App\Models\Category::with('children')
                ->where('slug', $request->input('category'))
                ->first();

            if ($category) {
                $ids = collect([$category->id])
                    ->merge($category->children->pluck('id'))
                    ->all();

                $query->whereIn('category_id', $ids);
            }
        }

        if ($request->filled('country')) {
            $query->where('country', $request->input('country'));
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->input('condition'));
        }

        if ($request->filled('metal')) {
            $query->where('metal', $request->input('metal'));
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

        $metals = Coin::query()
            ->select('metal')
            ->whereNotNull('metal')
            ->distinct()
            ->orderBy('metal')
            ->pluck('metal');

        $categories = \App\Models\Category::with('children')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        $currentCategory = $request->filled('category')
            ? \App\Models\Category::where('slug', $request->input('category'))->first()
            : null;

        return view('coins.index', compact(
            'coins', 'countries', 'conditions', 'metals', 'categories', 'currentCategory'
        ));
    }

    public function show(Coin $coin)
    {
        return view('coins.show', compact('coin'));
    }
}
