<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function index() {
        $row = Discount::all();
        if (count($row) == 0) {
            Discount::create([
                'discount_percentage' => 0.20,
                'minimum_purchase' => 10000
            ]);
        }
        $discount = Discount::first();
        return view('admin.discount.index', compact('discount'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        Discount::where('id', $id)->update($data);

        return redirect()->back()
            ->with('success', 'Discount was updated successfully.');
    }
}
