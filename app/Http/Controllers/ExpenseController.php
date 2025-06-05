<?php
// app/Http/Controllers/ExpenseController.php
namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $expenses = Expense::where('user_id', $user->id)->paginate(10);
        return view('expense.index', compact('expenses'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'jar' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255'
        ]);
        Expense::create([
            'date' => $request->date,
            'jar' => $request->jar,
            'amount' => $request->amount,
            'description' => $request->description,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('expense.index')->with('success', 'Chi tiêu đã được thêm thành công!');
    }

    public function update(Request $request, Expense $expense)
    {
        // Logic cập nhật chi tiêu
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return back()->with('success', 'Chi tiêu đã được xóa!');
    }
}