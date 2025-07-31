<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ExpenseCategory::get();
        return view('expense_category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id             = $request->id;
        $color_info     = ExpenseCategory::find($id);

        if ($color_info->status == 1) {
            $color_info->status = 2;
        } else {
            $color_info->status = 1;
        }

        $color_info->save();

        return "success";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_name' => 'required|unique:expense_categories',
        ]);

        $category_name = $request->category_name;

        $check_count = ExpenseCategory::where('category_name', $category_name)->count();
        if ($check_count > 0) {
            return "category_failed";
        }

        $data                 = new ExpenseCategory;
        $data->user_id        = Auth::id();
        $data->category_name  = $category_name;
        $data->status         = 1;
        $data->save();

        return "success";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id             = $request->id;
        $color_info     = ExpenseCategory::find($id);

        if ($color_info->status == 1) {
            $color_info->status = 2;
        } else {
            $color_info->status = 1;
        }

        $color_info->save();

        return "success";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $info = ExpenseCategory::find($id);

        return response()->json($info);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_name' => 'required|unique:expense_categories,category_name,' . $id,
        ]);

        $category_name = $request->category_name;

        $check_count = ExpenseCategory::where('category_name', $category_name)->whereNotIn('id', [$id])->count();
        if ($check_count > 0) {
            return "category_failed";
        }

        $data                 = ExpenseCategory::find($id);
        $data->user_id        = Auth::id();
        $data->category_name  = $category_name;
        $data->save();

        return "success";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = ExpenseCategory::find($id);
        if (!$category) {
            return redirect()->route('expensecategory.index')->with('failed', 'Category not found.');
        }

        if ($category->expense()->exists()) {
            return redirect()->route('expensecategory.index')->with('failed', 'Cannot delete category because it has associated expense.');
        }
        $category->delete();
        return redirect()->route('expensecategory.index')->with('success', 'Category deleted successfully.');
    }
}
