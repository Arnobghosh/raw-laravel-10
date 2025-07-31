<?php

namespace App\Http\Controllers;

use App\Models\Bank;

use App\Models\Cashbook;
use Illuminate\Http\Request;
use App\Models\BankTransaction;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    public $branch_id;

    public function __construct()
    {
        $this->branch_id = Auth::user()->branch_id ?? '';
    }

    public function index()
    {
        $data = Bank::with('branch', 'added_by')->when($this->branch_id > 0, function ($query) {
            $query->where('branch_id', $this->branch_id);
        })->orderBy('bank_name', 'asc')->get();


        return view('bank.index', compact('data'));
    }

    public function create()
    {
        $all_branch = Branch::when($this->branch_id > 0, function ($query) {
            $query->where('id', $this->branch_id);
        })->get();
        return view('bank.create', compact('all_branch'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type'              => 'required',
            'bank_name'         => 'required',
            'account_number'    => 'required|unique:banks',
            'bank_balance'      => 'required',
            'closing_date'      => 'required',
            'branch_id'         => 'required',
        ]);

        $closing_date = date("Y-m-d", strtotime($request->closing_date));


        $all_inputs                 = $request->all();
        $all_inputs['user_id']      = Auth::id();
        $all_inputs['opening_date'] = $closing_date;
        $bank_info = Bank::create($all_inputs);


        # BANK TRANSACTION DATA
        $transaction_data                       = new BankTransaction;
        $transaction_data['user_id']            = Auth::id();
        $transaction_data['branch_id']          = $request->branch_id;
        $transaction_data['bank_id']            = $bank_info->id;
        $transaction_data['type']               = 0;
        $transaction_data['purpose']            = "Opening Balnace";
        $transaction_data['debit']              = $request->bank_balance;
        $transaction_data['transaction_date']   = $closing_date;
        $transaction_data['on_transaction_date'] = $closing_date . " " . date("H:i:s");
        $transaction_data->save();


        return back()->with('success', 'Thanks! Bank / Mobile Bank Added Successfully Completed.');
    }


    public function show(Bank $bank)
    {
        $bank_transaction = BankTransaction::where('bank_id', $bank->id)->orderBy('on_transaction_date', 'asc')->get();

        return view('bank.show', compact('bank_transaction', 'bank'));
    }

    public function edit(Bank $bank)
    {
        return view('bank.edit', compact('bank'));
    }

    public function update(Request $request, Bank $bank)
    {

        $this->validate($request, [
            'type'              => 'required',
            'bank_name'         => 'required',
            'account_number'    => 'required|unique:banks,account_number,' . $bank->id,
        ]);

        $closing_date = date("Y-m-d", strtotime($request->closing_date));

        $bank_info                  = $bank;
        $all_inputs                 = $request->all();
        if ($request->type == 2) {
            $all_inputs['branch_name'] = '';
            $all_inputs['account_name'] = '';
        }
        $bank_info->update($all_inputs);

        return redirect()->route('bank.index')->with('success', 'Thanks! Bank Infromation Updated Successfully.');
    }

    public function destroy(Bank $bank)
    {
        $bank_transaction_check = BankTransaction::where('bank_id', $bank->id)->whereNotIn('type', [0])->count();
        if ($bank_transaction_check > 0) {
            return back()->with('failed', 'Sorry! Bank Already Has Transaction.');
        }


        $tran = BankTransaction::where('bank_id', $bank->id)->first();
        Cashbook::where('id', $tran->cashbook_id)->delete();
        BankTransaction::where('bank_id', $bank->id)->delete();
        $bank->delete();

        return redirect()->route('bank.index')->with('success', 'Thanks! Bank Infromation Delete Successfully.');
    }

    public function getbanktypewisebank(Request $request)
    {
        $bank_type      = $request->bank_type;

        $data = Bank::where('type', $bank_type)->get();
        return response()->json($data);
    }
}
