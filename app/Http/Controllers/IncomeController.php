<?php
// app/Http/Controllers/IncomeController.php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Http\Requests\StoreIncomeRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $query = Income::where('user_id', optional(Auth::user())->id)
                      ->orderBy('date', 'desc');

        // Áp dụng bộ lọc
        if ($request->has('period')) {
            switch ($request->period) {
                case 'month':
                    $query->currentMonth();
                    break;
                case 'quarter':
                    $query->currentQuarter();
                    break;
                case 'year':
                    $query->currentYear();
                    break;
            }
        }

        // Tìm kiếm
        if ($request->has('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $incomes = $query->paginate(10);

        return view('incomes.index', compact('incomes'));
    }

    public function store(StoreIncomeRequest $request)
    {
        Income::create([
            'date' => $request->date,
            'description' => $request->description,
            'user_id' => optional(Auth::user())->id
        ]);
        // Bạn có thể thêm các xử lý bổ sung tại đây nếu cần
        return response()->json([
            'success' => true,
            'message' => 'Thu nhập đã được thêm thành công!'
        ]);
    }

    public function update(StoreIncomeRequest $request, Income $income)
    {
        $this->authorize('update', $income);

        $income->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Thu nhập đã được cập nhật thành công!'
        ]);
    }

    public function destroy(Income $income)
    {
        $this->authorize('delete', $income);

        $income->delete();

        return response()->json([
            'success' => true,
            'message' => 'Thu nhập đã được xóa thành công!'
        ]);
    }
}