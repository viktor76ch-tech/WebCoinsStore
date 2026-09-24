<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    public function index(Request $request)
    {
        $query = Coin::query()->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('with_trashed')) {
            $query->withTrashed();
        }

        $coins = $query->paginate(20)->withQueryString();

        return view('admin.coins.index', compact('coins'));
    }

    public function create()
    {
        return view('admin.coins.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        // Если quantity = 0, сразу помечаем как sold
        if ((int) $data['quantity'] === 0) {
            $data['status'] = 'sold';
        }

        Coin::create($data);

        return redirect()->route('admin.coins.index')
            ->with('success', 'Монета добавлена.');
    }

    public function edit(Coin $coin)
    {
        return view('admin.coins.edit', compact('coin'));
    }

    public function update(Request $request, Coin $coin)
    {
        $data = $this->validateData($request);

        // Синхронизация статуса с количеством
        if ((int) $data['quantity'] === 0) {
            $data['status'] = 'sold';
        } elseif ($data['status'] === 'sold' && (int) $data['quantity'] > 0) {
            $data['status'] = 'available';
        }

        $coin->update($data);

        return redirect()->route('admin.coins.index')
            ->with('success', 'Монета обновлена.');
    }

    public function destroy(Coin $coin)
    {
        $coin->delete();

        return back()->with('success', 'Монета удалена.');
    }

    public function restore(int $id)
    {
        $coin = Coin::withTrashed()->findOrFail($id);
        $coin->restore();

        return back()->with('success', 'Монета восстановлена.');
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'year' => 'required|integer|min:1000|max:2100',
            'country' => 'required|string|max:100',
            'condition' => 'required|string|max:50',
            'status' => 'required|in:available,reserved,sold',
            'image_url' => 'nullable|url|max:500',
        ]);
    }
}
