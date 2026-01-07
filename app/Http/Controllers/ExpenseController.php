<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Session::put('menu', 'Expense');
        $pagetitle = 'Expense';

        if ($request->ajax()) {

            $query = DB::table('expense_master')
                ->leftJoin('chartofaccount', 'chartofaccount.ChartOfAccountID', '=', 'expense_master.ChartOfAccountID')
                ->leftJoin('supplier', 'supplier.SupplierID', '=', 'expense_master.SupplierID')
                ->select(
                    'expense_master.ExpenseMasterID',
                    'expense_master.ExpenseNo',
                    'expense_master.Date',
                    'chartofaccount.ChartOfAccountName',
                    'supplier.SupplierName',
                    'expense_master.ReferenceNo'
                )
                ->orderBy('expense_master.ExpenseMasterID', 'desc');
                

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $viewUrl = route('expense.show', $row->ExpenseMasterID);
                    $editUrl = route('expense.edit', $row->ExpenseMasterID);

                    return '
                    <div class="d-flex align-items-center col-actions">

                        <a href="'.$viewUrl.'">
                            <i class="font-size-18 mdi mdi-eye-outline align-middle me-1 text-secondary"></i>
                        </a>

                        <a href="'.$editUrl.'">
                            <i class="font-size-18 bx bx-pencil align-middle me-1 text-secondary"></i>
                        </a>

                        <a href="javascript:void(0)"
                        class="btn-delete"
                        data-id="'.$row->ExpenseMasterID.'">
                            <i class="font-size-18 bx bx-trash align-middle me-1 text-danger"></i>
                        </a>

                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('expense.expense', compact('pagetitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pagetitle = 'Expense';

        Session::put('menu', 'Expense');
        $chartOfAccountFrom = DB::table('chartofaccount')->whereIn('Category', ['CASH', 'CARD', 'BANK'])->get();
        $expenseAccounts = DB::table('chartofaccount')->where('Level', '3')
        ->where('CODE','E')
        ->get();

        $supplier = DB::table('supplier')->get();
        $job = DB::table('job')->get();

        $expenseNo = Account::generateExpenseNo();

        return view('expense.expense_create', compact('expenseNo', 'chartOfAccountFrom', 'expenseAccounts', 'supplier', 'pagetitle', 'job'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        session::put('menu', 'Expense');
        $pagetitle = 'Expense';

        DB::BeginTransaction();
        try{

            $expense_mst = array(
                'ExpenseNo' => $request->ExpenseNo,
                'Date' => $request->Date,
                'JobID' => $request->JobID,
                'ChartOfAccountID' => $request->ChartOfAccountID_From,
                'JobID' => $request->JobID,
                'SupplierID' => $request->SupplierID,
                'ReferenceNo' => $request->ReferenceNo,
                'Amount' => $request->TotalBeforeTax,
                'TaxType' => $request->TaxType,
                'Tax' => $request->TotalTax,
                'GrantTotal' => $request->GrandTotal,
            );
            $ExpenseMasterID = DB::table('expense_master')->insertGetId($expense_mst);

            $this->detailAndJournalEntries($request, $ExpenseMasterID);
            
            DB::commit();

            return view('expense.expense', compact('pagetitle'));

        }catch(\Exception $e){

             DB::rollback();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pagetitle = 'Expense View ';
        $company = DB::table('company')->get();
        $expense = DB::table('expense_master')
        ->leftJoin('chartofaccount', 'chartofaccount.ChartOfAccountID','=','expense_master.ChartOfAccountID')
        ->leftJoin('supplier', 'supplier.SupplierID','=','expense_master.SupplierID')
        ->select(
                'expense_master.*',
                'chartofaccount.ChartOfAccountName',
                'supplier.SupplierName',
            )
        ->where('expense_master.ExpenseMasterID', $id)
        ->first();

        $expenseDetails = DB::table('expense_detail')
        ->leftJoin('chartofaccount', 'chartofaccount.ChartOfAccountID','=','expense_detail.ChartOfAccountID')
        ->select('expense_detail.*','chartofaccount.ChartOfAccountName')
        ->where('expense_detail.ExpenseMasterID', $id)
        ->get();

        $journal = DB::table('journal')->where('ExpenseMasterID', $id)->get();


        return view('expense.expense_view', compact('expense', 'expenseDetails', 'pagetitle', 'company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        session::put('menu', 'Expense');
        $pagetitle = 'Expense';
        $chartOfAccountFrom = DB::table('chartofaccount')->whereIn('Category', ['CASH', 'CARD', 'BANK'])->get();
        
        $expenseAccounts = DB::table('chartofaccount')->where('Level', '3')
        ->where('CODE','E')
        ->get();
        $supplier = DB::table('supplier')->get();
        $job = DB::table('job')->get();
        
        $expense = DB::table('expense_master')->where('ExpenseMasterID', $id)->first();
        $expenseDetails = DB::table('expense_detail')->where('ExpenseMasterID', $id)->get();


        return view('expense.expense_edit', compact('chartOfAccountFrom', 'expenseAccounts', 'supplier', 'pagetitle', 'job','expense','expenseDetails'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ExpenseMasterID)
    {
        
        
        session::put('menu', 'Expense');
        $pagetitle = 'Expense';

        DB::BeginTransaction();
        try{

            $expense_mst = array(
                'Date' => $request->Date,
                'JobID' => $request->JobID,
                'ChartOfAccountID' => $request->ChartOfAccountID_From,
                'JobID' => $request->JobID,
                'SupplierID' => $request->SupplierID,
                'ReferenceNo' => $request->ReferenceNo,
                'Amount' => $request->TotalBeforeTax,
                'TaxType' => $request->TaxType,
                'Tax' => $request->TotalTax,
                'GrantTotal' => $request->GrandTotal,
            );
            DB::table('expense_master')->where('ExpenseMasterID', $ExpenseMasterID)->update($expense_mst);
           

            DB::table('expense_detail')->where('ExpenseMasterID', $ExpenseMasterID)->delete();
            DB::table('journal')->where('ExpenseMasterID', $ExpenseMasterID)->delete();
            
            
            $this->detailAndJournalEntries($request, $ExpenseMasterID);
            
            DB::commit();


            return view('expense.expense', compact('pagetitle'));

        }catch(\Exception $e){

            DB::rollback();

            dd($e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
    
        // Get the invoice details
        $invoice_mst = DB::table('expense_master')->where('ExpenseMasterID', $id)->first();
        
         // Check if invoice exists
        if (!$invoice_mst) {
            return redirect()->back()->with('error', 'Invoice not found.')->with('class', 'danger');
        }
 
        
        DB::table('journal')->where('ExpenseMasterID', $id)->delete();
        DB::table('expense_detail')->where('ExpenseMasterID', $id)->delete();
        DB::table('expense_master')->where('ExpenseMasterID', $id)->delete();


        return response()->json([
            'success' => true,
            'message' => 'Expense deleted successfully'
        ]);   
    }

    public function detailAndJournalEntries(Request $request, $ExpenseMasterID)
    {
        $data = [
            'ExpenseMasterID' => $ExpenseMasterID,
            'VHNO' => $request->ExpenseNo,
            'SupplierID' => $request->input('SupplierID'),
            'Date' => $request->input('Date'),
            'JobID' => $request->JobID,
            'Narration' => $request->ExpenseNo.' '.$request->ReferenceNo
        ];

        for ($i = 0; $i < count($request->ChartOfAccountID); $i++) 
        {
            $expense_detail = array(
            'ExpenseMasterID' =>  $ExpenseMasterID,
            'Date' => $request->Date,
            'JobID' => $request->JobID,
            'ChartOfAccountID' => $request->ChartOfAccountID[$i],
            'Notes' => $request->Notes[$i],
            'Amount' => $request->Amount[$i],
            'TaxPer' => $request->TaxPer[$i],
            'Tax' => $request->Tax[$i],
            'Total' => $request->Total[$i],
            );

            DB::table('expense_detail')->insertGetId($expense_detail);

            //Input Tax - DR
            if($request->Tax > 0){
                $inputTax = array_merge($data,[
                    'ChartOfAccountID' => 112312,
                    'Dr' => $request->Tax[$i],
                ]);
                DB::table('journal')->insertGetId($inputTax);
            }
            //Expense Account - DR
            $expenseAccount = array_merge($data,[
                'ChartOfAccountID' => $request->ChartOfAccountID[$i],
                'Dr' => $request->Total[$i],
            ]);
            DB::table('journal')->insert($expenseAccount);
        
        }    

        //Cash / Bank - CR 
        $paidThorugh = array_merge($data,[
            'ChartOfAccountID' => $request->ChartOfAccountID_From,
            'Cr' => $request->GrandTotal,
        ]);
        DB::table('journal')->insertGetId($paidThorugh);
        
    }
}    
