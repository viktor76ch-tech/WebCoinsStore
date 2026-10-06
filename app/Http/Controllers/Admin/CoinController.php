<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCoinRequest;
use App\Http\Requests\UpdateCoinRequest;

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

    public function store(StoreCoinRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image_file')) {
            $data['image_url'] = $request->file('image_file')
                ->store('coins', 'public');
        }

        unset($data['image_file']);

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

    public function update(UpdateCoinRequest $request, Coin $coin)
    {
        $data = $request->validated();

        if ($request->hasFile('image_file')) {
            if ($coin->image_url && !str_starts_with($coin->image_url, 'http')) {
                \Storage::disk('public')->delete($coin->getRawOriginal('image_url'));
            }

            $data['image_url'] = $request->file('image_file')
                ->store('coins', 'public');
        }

        unset($data['image_file']);

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
}
