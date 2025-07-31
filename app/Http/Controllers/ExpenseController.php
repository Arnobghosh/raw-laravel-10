<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\BankTransaction;
use App\Models\Cashbook;
use App\Models\Bank;
use App\Models\Pettycash;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('expense.index');
    }

    public function expensedata()
    {
        $posts      = Expense::with('added_by', 'category')->OrderBy('id', 'desc')->get();

        $this->i    = 1;
        return DataTables::of($posts)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('action', function ($data) {
                $htmlData = '';
                $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-danger btn-sm tableDelete" title="Delete"><i class="fa fa-trash"></i></a>';
                return $htmlData;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_category = ExpenseCategory::where('status', 1)->orderBy('category_name', 'asc')->get();
        $all_bank     = Bank::orderBy('bank_name', 'asc')->get();


        return view('expense.create', compact('all_category', 'all_bank'));
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
            'category_id' => 'required',
            'expense_amount' => 'required',
        ]);

        $category_id        = $request->category_id;
        $bank_id            = $request->bank_id;
        $expense_amount     = $request->expense_amount;
        $remarks            = $request->remarks;
        $expense_date       = date("Y-m-d", strtotime($request->expense_date));
        $on_expense_date    = $expense_date . " " . date("H:i:s");


        # CHECK BALANCE 
        if ($bank_id != "") {
            $bank_info = Bank::find($bank_id);
            if ($bank_info->bank_balance < $expense_amount) {
                $data = [
                    'status' => 'invalid_bank_balance',
                    'message' => 'Your bank account does not have enough balance.',
                ];

                return  response()->json($data);
            }
        }

        if ($bank_id != "") {
            $purpose = "Expense By : " . $bank_info->bank_name . " " . $bank_info->account_number;
            $cloumn_name = 'bank_credit';
        }

        $payment_data                   = new Expense;
        $payment_data->user_id          = Auth::id();
        $payment_data->category_id      = $category_id;
        $payment_data->bank_id          = $bank_id;
        $payment_data->expense_amount   = $expense_amount;
        $payment_data->remarks          = $remarks;
        $payment_data->type             = $bank_id ? 1 : 2;
        $payment_data->expense_date     = $expense_date;
        $payment_data->on_expense_date  = $on_expense_date;
        $payment_data->save();
        $payment_id                      = $payment_data->id;


        if ($bank_id != "") {
            # BANK TRANSACTION DATA 
            $transaction_data                       = new BankTransaction;
            $transaction_data['user_id']            = Auth::user()->id;
            $transaction_data['bank_id']            = $bank_id;
            $transaction_data['type']               = 5;
            $transaction_data['tranaction_note']    = $remarks;
            $transaction_data['purpose']            = "Expense";
            $transaction_data['credit']              = $expense_amount;
            $transaction_data['transaction_date']    = $expense_date;
            $transaction_data['on_transaction_date'] = $on_expense_date;

            $payment_data->transactionables()->save($transaction_data);

            $bank_info->bank_balance            = $bank_info->bank_balance - $expense_amount;
            $bank_info->save();
        }

        $data = [
            'status' => 'success',
            'message' => 'Expense Successfully Completed',
        ];

        return  response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {

        $bank_id            = $expense->bank_id;
        $expense_amount     = $expense->expense_amount;
        $category_id        = $expense->category_id;

        $transactions = Expense::with('transactionables')->get();

        try {
            DB::beginTransaction();

            if ($bank_id && $expense_amount) {
                $bank_id            = $expense->bank_id;
                $bank_info          = Bank::find($bank_id);
                $bank_info->bank_balance  += $expense_amount;
                $bank_info->save();
            }

            $expense->transactionables()->delete();
            $expense->delete();

            DB::commit();

            $response_data = [
                'status' => 'success',
                'message' => 'Thanks Expense Delete Successfully Completed '
            ];


            return response()->json($response_data);
        } catch (Exception $e) {
            DB::rollBack(); // Rollback the transaction in case of an error
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
