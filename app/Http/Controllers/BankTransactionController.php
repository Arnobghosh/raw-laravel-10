<?php

namespace App\Http\Controllers;


use Exception;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Cashbook;

use App\Models\Pettycash;
use Illuminate\Http\Request;
use App\Models\BankTransaction;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\DeleteBankTransaction;

class BankTransactionController extends Controller
{
    public $branch_id;

    public function __construct()
    {
        $this->branch_id = Auth::user()->branch_id ?? '';
    }
    public function bankdeposit()
    {
        return view('banktransaction.bankdeposit');
    }


    public function addbankdeposit()
    {
        $all_branch = Branch::when($this->branch_id > 0, function ($query) {
            return $query->where('id', $this->branch_id);
        })->get();
        $transfer_branch = Branch::when($this->branch_id > 0, function ($query) {
            return $query->whereNotIn('id', [$this->branch_id]);
        })->get();
        $all_bank = Bank::get();
        return view('banktransaction.addbankdeposit', compact('all_bank', 'all_branch', 'transfer_branch'));
    }

    public function bankdepositdata()
    {
        $posts      = BankTransaction::with('added_by', 'bank')
            ->OrderBy('id', 'desc')
            ->where('type', 10)
            ->get();

        $this->i    = 1;
        return DataTables::of($posts)
            ->addColumn('id', function () {
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


    // public function savebankdeposit(Request $request)
    // {
    //     $this->validate($request, [
    //         'bank_id'                   => 'required',
    //         'deposit_amount'            => 'required',
    //         'confirm_deposit_amount'    => 'required|same:deposit_amount',
    //         'transaction_date'          => 'required',
    //     ]);

    //     $bank_id                = $request->bank_id;
    //     $deposit_amount         = $request->deposit_amount;
    //     $transaction_date       = date('Y-m-d', strtotime($request->transaction_date));
    //     $on_transaction_date    = date('Y-m-d', strtotime($request->transaction_date)) . " " . date("H:i:s");
    //     $tranaction_note        = $request->tranaction_note;
    //     $remarks                = $request->remarks;

    //     $bank_info              = Bank::find($bank_id);
    //     $pettycash_data         = Pettycash::first();

    //     // if (!$pettycash_data) {
    //     //     $data = [
    //     //         'status' => 'invalid_pettycash',
    //     //         'message' => 'Add Pettycash Balance First.',
    //     //     ];

    //     //     return  response()->json($data);
    //     // }

    //     // if ($pettycash_data->pettycash_balance < $deposit_amount) {
    //     //     $data = [
    //     //         'status' => 'invalid_deposit',
    //     //         'message' => "You don't have enough money in your balance.",
    //     //     ];

    //     //     return  response()->json($data);
    //     // }

    //     $purpose = "Bank Deposit By : " . $bank_info->bank_name . " " . $bank_info->account_number;

    //     # CASHBOOK
    //     $cashbook_data                          = new Cashbook;
    //     $cashbook_data['user_id']               = Auth::id();
    //     $cashbook_data['bank_id']               = $bank_id;
    //     $cashbook_data['purpose']               = $purpose;
    //     $cashbook_data['credit']                = $deposit_amount;
    //     $cashbook_data['bank_debit']            = $deposit_amount;
    //     $cashbook_data['type']                  = 15;
    //     $cashbook_data['transaction_date']      = $transaction_date;
    //     $cashbook_data['on_transaction_date']   = $on_transaction_date;
    //     $cashbook_data->save();
    //     $cashbook_id                            = $cashbook_data->id;


    //     # BANK TRANSACTION DATA
    //     $transaction_data                           = new BankTransaction;
    //     $transaction_data['user_id']                = Auth::id();
    //     $transaction_data['bank_id']                = $bank_id;
    //     $transaction_data['type']                   = 7;
    //     $transaction_data['purpose']                = $purpose;
    //     $transaction_data['debit']                  = $deposit_amount;
    //     $transaction_data['transaction_date']       = $transaction_date;
    //     $transaction_data['on_transaction_date']    = $on_transaction_date;
    //     $transaction_data['remarks']                = $remarks;
    //     $transaction_data['tranaction_note']        = $tranaction_note;
    //     $transaction_data['cashbook_id']            = $cashbook_id;
    //     $transaction_data->save();

    //     $pettycash_data->pettycash_balance  = $pettycash_data->pettycash_balance - $deposit_amount;
    //     $pettycash_data->save();

    //     $bank_info->bank_balance            = $bank_info->bank_balance + $deposit_amount;
    //     $bank_info->save();

    //     $data = [
    //         'status' => 'success',
    //         'message' => "Deposit Successfully Completed.",
    //     ];

    //     return  response()->json($data);
    // }

    public function savebankdeposit(Request $request)
    {

        $this->validate($request, [
            'send_bank_id'              => 'required',
            'send_deposit_amount'       => 'required',
            'bank_id'                   => 'required',
            'receive_amount'            => 'required',
            'send_branch_id'            => 'required',
            'branch_id'            => 'required',
        ]);


        $branch_id              = $request->branch_id;
        $send_branch_id         = $request->send_branch_id;
        $send_bank_id           = $request->send_bank_id;
        $deposit_amount         = $request->send_deposit_amount;
        $bank_id                = $request->bank_id;
        $receive_amount         = $request->receive_amount;
        $referance_no           = $request->referance_no;

        $transaction_date       = date('Y-m-d');
        $on_transaction_date    = date('Y-m-d H:i:s');
        $random_number          = 'Transaction-' . time();
        $tranaction_note        = $request->tranaction_note;
        $transaction_document   = $request->transaction_document;

        # SENDING TRANSACTION SECTIO
        $send_bank_info              = Bank::find($send_bank_id);


        if ($bank_id == $send_bank_id) {
            $data = [
                'status' => 'invalid_deposit',
                'message' => "Send & Receive Bank are same.",
            ];

            return  response()->json($data);
        }
        if ($send_bank_info->bank_balance < $deposit_amount) {
            $data = [
                'status' => 'invalid_deposit',
                'message' => "You don't have enough money in your bank balance.",
            ];

            return  response()->json($data);
        }

        try {
            DB::beginTransaction();
            $receive_bank_info = Bank::find($bank_id);

            $purpose = "Balance Send To : " . $receive_bank_info->bank_name . " " . $receive_bank_info->account_number;

            # BANK TRANSACTION DATA
            $transaction_data                           = new BankTransaction;
            $transaction_data['user_id']                = Auth::id();
            // $transaction_data['random_number']          = $random_number;
            $transaction_data['bank_id']                = $send_bank_id;
            $transaction_data['branch_id']              = $send_branch_id;
            $transaction_data['remarks']                = $tranaction_note;
            $transaction_data['purpose']                = $purpose;
            $transaction_data['type']                   = 11;
            $transaction_data['credit']                 = $deposit_amount;
            $transaction_data['tranaction_note']        = $referance_no;
            $transaction_data['transaction_date']       = $transaction_date;
            $transaction_data['on_transaction_date']    = $on_transaction_date;


            if ($request->hasFile('transaction_document')) {
                $file_names = "Transaction-" . $send_bank_id . "-" . time() . "-" . $request->transaction_document->extension();
                $request->transaction_document->move(public_path('images/transaction/'), $file_names);
                $transaction_data->transaction_document = $file_names;
            }
            $transaction_data->save();

            $send_bank_info->bank_balance               = $send_bank_info->bank_balance - $deposit_amount;
            $send_bank_info->save();

            $receive_purpose                            = "Balance Receive By : " . $send_bank_info->bank_name . " " . $send_bank_info->account_number;

            # BANK TRANSACTION DATA
            $rtransaction_data                           = new BankTransaction;
            $rtransaction_data['user_id']                = Auth::id();
            $rtransaction_data['branch_id']              = $branch_id;
            $rtransaction_data['bank_id']                = $bank_id;
            $transaction_data['remarks']                 = $tranaction_note;
            $rtransaction_data['type']                   = 10;
            $rtransaction_data['purpose']                = $receive_purpose;
            $rtransaction_data['debit']                  = $receive_amount;
            $transaction_data['tranaction_note']         = $referance_no;
            $rtransaction_data['transaction_date']       = $transaction_date;
            $rtransaction_data['on_transaction_date']    = $on_transaction_date;
            // $rtransaction_data['cashbook_id']            = $cashbook_id;
            $rtransaction_data->save();

            $receive_bank_info->bank_balance            = $receive_bank_info->bank_balance + $receive_amount;
            $receive_bank_info->save();

            DB::commit();

            $data = [
                'status' => 'success',
                'message' => "Transaction Successfully Completed.",
            ];
            return  response()->json($data);
        } catch (Exception $e) {
            DB::rollBack();
            $data = [
                'status' => 'error',
                'message' => "Error Occurred While Performing Transaction.",
            ];
            return  response()->json($data);
        }
    }

    public function bankwithdraw()
    {
        return view('banktransaction.bankwithdraw');
    }

    public function bankwithdrawdata()
    {
        $posts      = BankTransaction::with('added_by', 'bank', 'bank.account')
            ->OrderBy('id', 'desc')
            ->where('type', 8)
            ->get();

        $this->i    = 1;
        return DataTables::of($posts)
            ->addColumn('id', function () {
                return $this->i++;
            })
            ->addColumn('action', function ($data) {
                $htmlData = '';
                if (Auth::user()->can('delete bank withdraw')) {
                    $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-danger btn-sm tableDelete" title="Delete"><i class="fa fa-trash"></i></a>';
                }
                return $htmlData;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function addbankwithdraw()
    {
        $branchId = Auth::user()->branch_id;
        $all_bank = Bank::with('account')->when($branchId > 0, function ($query) use ($branchId) {
            $query->where('branch_id', $branchId);
        })->get();

        return view('banktransaction.addbankwithdraw', compact('all_bank'));
    }

    public function savebankwithdraw(Request $request)
    {
        $this->validate($request, [
            'bank_id'                    => 'required',
            'withdraw_amount'            => 'required',
            'confirm_withdraw_amount'    => 'required|same:withdraw_amount',
            'transaction_date'           => 'required',
        ]);

        $bank_id                = $request->bank_id;
        $withdraw_amount        = $request->withdraw_amount;
        $transaction_date       = date('Y-m-d', strtotime($request->transaction_date));
        $on_transaction_date    = date('Y-m-d', strtotime($request->transaction_date)) . " " . date("H:i:s");
        $tranaction_note        = $request->tranaction_note;
        $remarks                = $request->remarks;

        $bank_info              = Bank::find($bank_id);
        $pettycash_data         = Pettycash::first();

        if (!$pettycash_data) {
            $data = [
                'status' => 'invalid_pettycash',
                'message' => 'Add Pettycash Balance First.',
            ];

            return  response()->json($data);
        }

        if ($bank_info->bank_balance < $withdraw_amount) {
            $data = [
                'status' => 'invalid_deposit',
                'message' => "You don't have enough money in your balance.",
            ];

            return  response()->json($data);
        }

        $purpose = "Bank Withdraw By : " . $bank_info->bank_name . " " . $bank_info->account_number;

        # CASHBOOK
        $cashbook_data                          = new Cashbook;
        $cashbook_data['user_id']               = Auth::id();
        $cashbook_data['bank_id']               = $bank_id;
        $cashbook_data['purpose']               = $purpose;
        $cashbook_data['debit']                 = $withdraw_amount;
        $cashbook_data['bank_credit']           = $withdraw_amount;
        $cashbook_data['type']                  = 15;
        $cashbook_data['transaction_date']      = $transaction_date;
        $cashbook_data['on_transaction_date']   = $on_transaction_date;
        $cashbook_data->save();
        $cashbook_id                            = $cashbook_data->id;


        # BANK TRANSACTION DATA
        $transaction_data                           = new BankTransaction;
        $transaction_data['user_id']                = Auth::id();
        $transaction_data['bank_id']                = $bank_id;
        $transaction_data['type']                   = 8;
        $transaction_data['purpose']                = $purpose;
        $transaction_data['credit']                 = $withdraw_amount;
        $transaction_data['transaction_date']       = $transaction_date;
        $transaction_data['on_transaction_date']    = $on_transaction_date;
        $transaction_data['remarks']                = $remarks;
        $transaction_data['tranaction_note']        = $tranaction_note;
        $transaction_data['cashbook_id']            = $cashbook_id;
        $transaction_data->save();

        $pettycash_data->pettycash_balance  = $pettycash_data->pettycash_balance + $withdraw_amount;
        $pettycash_data->save();

        $bank_info->bank_balance            = $bank_info->bank_balance - $withdraw_amount;
        $bank_info->save();

        $data = [
            'status' => 'success',
            'message' => "Withdraw Successfully Completed.",
        ];

        return  response()->json($data);
    }

    public function deletebanktransaction($id)
    {
        $transaction_info = BankTransaction::find($id);
        $bank_id          = $transaction_info->bank_id;
        $type             = $transaction_info->type;
        $debit            = $transaction_info->debit;
        $credit           = $transaction_info->credit;

        $bank_info        = Bank::find($bank_id);

        if ($type == 10) {

            if ($bank_info->bank_balance < $debit) {
                return $response_data = [
                    'status' => 'not_available_balance',
                    'message' => 'Deposit Amount Bigger Then Bank Balnace - ' . $bank_info->bank_name . " - " . $bank_info->account_number,
                ];
                return response()->json($response_data);
            }

            $transactionData               = $transaction_info->toArray();
            $transactionData['deleted_by'] = Auth::id();


            $bank_info->bank_balance            = $bank_info->bank_balance - $debit;
            $bank_info->save();

            $transaction_info->delete();
        } else {

            $transactionData               = $transaction_info->toArray();
            $transactionData['deleted_by'] = Auth::id();

            $bank_info->bank_balance            = $bank_info->bank_balance + $credit;
            $bank_info->save();

            $transaction_info->delete();
        }

        return $response_data = [
            'status' => 'success',
            'message' => 'Transaction History Delete Successfully. ',
        ];
        return response()->json($response_data);
    }

    public function getbranchwisebank(Request $request)
    {
        $branch_id = $request->branch_id;

        $data = Bank::with('account', 'branch')->where('branch_id', $branch_id)->get();

        return response()->json($data);
    }
}
