<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LedgerReportExport;

class LedgerExportController extends Controller
{
    public function PartyLedger1Excel(Request $request)
    {
        ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////////
        $allow = check_role(session::get('UserID'), 'Party Ledger', 'PDF');
        if ($allow == 0) {
            return redirect()->back()->with('error', 'You access is limited')->with('class', 'danger');
        }
        ////////////////////////////END SCRIPT ////////////////////////////////////////////////

        session::put('menu', 'PartyLedger');
        $pagetitle = 'Party Ledger';

        session::put('StartDate', $request->StartDate);
        session::put('EndDate', $request->EndDate);

        $vouchertype = DB::table('voucher_type')->where('VoucherTypeID', $request->VoucherTypeID)->get();
        $where = array();

        if ($request->VoucherTypeID > 0) {
            $where = Arr::add($where, 'JournalType', $vouchertype[0]->VoucherCode);
        }

        if ($request->PartyID > 0) {
            $where = Arr::add($where, 'PartyID', $request->PartyID);
        }

        if ($request->ChartOfAccountID > 0) {
            $where = Arr::add($where, 'ChartOfAccountID', $request->ChartOfAccountID);
        }

        $sql = DB::table('journal')
            ->select(DB::raw('sum(if(ISNULL(Dr),0,Dr)-if(ISNULL(Cr),0,Cr)) as Balance'))
            // ->where('PartyID',$request->PartyID)
            ->where($where)
            ->where('Date', '<', $request->StartDate)
            // ->whereBetween('date',array($request->StartDate,$request->EndDate))
            ->get();
        // dd($sql[0]->Balance);
        // $sql= DB::select( DB::raw( 'SET @total := '.$sql[0]->Balance.''));
        // $sql= DB::select( DB::raw( 'select @total as t'));
        $sql[0]->Balance = ($sql[0]->Balance == null) ? '0' :  $sql[0]->Balance;
        // $a = DB::select(DB::raw('select * from v_journal where PartyID = @total'));
        // $journal = DB::select(DB::raw('SELECT a.JournalID, a.ChartOfAccountID, a.*, IF(ISNULL(a.Dr),0,a.Dr) as Dr, a.Cr,sum(if(ISNULL(b.Dr),0,b.Dr)-if(ISNULL(b.Cr),0,b.Cr))+'.$sql[0]->Balance.' as Balance FROM   v_journal a,  v_journal b WHERE b.JournalID <= a.JournalID and a.PartyID='.$request->PartyID.' and b.PartyID='.$request->PartyID.' and a.ChartOfAccountID=110400 and b.ChartOfAccountID=110400 GROUP BY a.JournalID, a.ChartOfAccountID, a.Dr, a.Cr ORDER BY a.JournalID'));
        // $a = DB::table('v_journal')->where('PartyID',DB::raw( '@total'))->get();
        $party = DB::table('party')->where('PartyID', $request->PartyID)->get();
        $journal = DB::table('v_journal')->where('PartyID', $request->PartyID)
            ->whereBetween('Date', array($request->StartDate, $request->EndDate))
            ->where($where)
            ->orderBy('Date', 'asc')
            ->get();

        $data = compact('journal', 'pagetitle', 'sql', 'party');
        return Excel::download(new LedgerReportExport('party_ledger1pdf', $data), 'Party Ledger.xlsx');
    }

    public function SupplierLedger1Excel(Request $request)
    {
        ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////////
        $allow = check_role(session::get('UserID'), 'Supplier Ledger', 'PDF');
        if ($allow == 0) {
            return redirect()->back()->with('error', 'You access is limited')->with('class', 'danger');
        }
        ////////////////////////////END SCRIPT ////////////////////////////////////////////////
        // dd($request->all());

        session::put('menu', 'SupplierLedger');
        $pagetitle = 'Supplier Ledger';


        $sql = DB::table('journal')
            ->select(DB::raw('sum(if(ISNULL(Dr),0,Dr)-if(ISNULL(Cr),0,Cr)) as Balance'))
            ->where('SupplierID', $request->SupplierID)
            ->where('ChartOfAccountID', $request->ChartOfAccountID)
            ->where('Date', '<', $request->StartDate)
            // ->whereBetween('date',array($request->StartDate,$request->EndDate))
            ->get();
        // dd($sql[0]->Balance);
        // $sql= DB::select( DB::raw( 'SET @total := '.$sql[0]->Balance.''));
        // $sql= DB::select( DB::raw( 'select @total as t'));
        $sql[0]->Balance = ($sql[0]->Balance == null) ? '0' :  $sql[0]->Balance;
        // $a = DB::select(DB::raw('select * from v_journal where PartyID = @total'));
        // $journal = DB::select(DB::raw('SELECT a.JournalID, a.ChartOfAccountID, a.*, IF(ISNULL(a.Dr),0,a.Dr) as Dr, a.Cr,sum(if(ISNULL(b.Dr),0,b.Dr)-if(ISNULL(b.Cr),0,b.Cr))+'.$sql[0]->Balance.' as Balance FROM   v_journal a,  v_journal b WHERE b.JournalID <= a.JournalID and a.PartyID='.$request->PartyID.' and b.PartyID='.$request->PartyID.' and a.ChartOfAccountID=110400 and b.ChartOfAccountID=110400 GROUP BY a.JournalID, a.ChartOfAccountID, a.Dr, a.Cr ORDER BY a.JournalID'));
        // $a = DB::table('v_journal')->where('PartyID',DB::raw( '@total'))->get();
        $supplier = DB::table('supplier')->where('SupplierID', $request->SupplierID)->get();
        $journal = DB::table('v_journal')->where('SupplierID', $request->SupplierID)
            ->whereBetween('Date', array($request->StartDate, $request->EndDate))
            ->where('ChartOfAccountID', $request->ChartOfAccountID)
            ->orderBy('Date', 'asc')
            ->get();
            
        $data = compact('journal', 'pagetitle', 'sql', 'supplier');
        return Excel::download(new LedgerReportExport('supplier_ledger1pdf', $data), 'Supplier Ledger.xlsx');
    }

    public function GeneralLedger1Excel(Request $request)
    {
        ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////////
        $allow = check_role(session::get('UserID'), 'General Ledger', 'PDF');
        if ($allow == 0) {
            return redirect()->back()->with('error', 'You access is limited')->with('class', 'danger');
        }
        ////////////////////////////END SCRIPT ////////////////////////////////////////////////
        // dd($request->all());

        session::put('menu', 'GeneralLedger');
        $pagetitle = 'General Ledger';

        if ($request->ChartOfAccountID > 0) {
            $sql = DB::table('journal')
                ->select(DB::raw('sum(if(ISNULL(Dr),0,Dr)-if(ISNULL(Cr),0,Cr)) as Balance'))
                // ->where('SupplierID',$request->SupplierID)
                ->whereIn('ChartOfAccountID', array($request->ChartOfAccountID, $request->ChartOfAccountID1))
                ->where('Date', '<', $request->StartDate)
                // ->whereBetween('date',array($request->StartDate,$request->EndDate))
                ->get();
            $journal = DB::table('v_journal')
                // ->where('SupplierID',$request->SupplierID)
                ->whereBetween('Date', array($request->StartDate, $request->EndDate))
                ->whereIn('ChartOfAccountID', array($request->ChartOfAccountID, $request->ChartOfAccountID1))
                ->orderBy('Date', 'asc')
                ->get();
            $journal_summary = DB::table('journal')
                ->select(DB::raw('sum(if(ISNULL(Dr),0,Dr)) as Dr'), DB::raw('sum(if(ISNULL(Cr),0,Cr)) as Cr'))
                ->whereBetween('Date', array($request->StartDate, $request->EndDate))
                ->whereIn('ChartOfAccountID', array($request->ChartOfAccountID, $request->ChartOfAccountID1))
                ->get();
        } else {
            $sql = DB::table('journal')
                ->select(DB::raw('sum(if(ISNULL(Dr),0,Dr)-if(ISNULL(Cr),0,Cr)) as Balance'))
                // ->where('SupplierID',$request->SupplierID)
                // ->whereIn('ChartOfAccountID',[110101,110250,110201,110101])
                ->where('Date', '<', $request->StartDate)
                // ->whereBetween('date',array($request->StartDate,$request->EndDate))
                ->get();
            $journal = DB::table('v_journal')
                // ->where('SupplierID',$request->SupplierID)
                ->whereBetween('Date', array($request->StartDate, $request->EndDate))
                // ->whereIn('ChartOfAccountID',[110101,110250,110201,110101])
                ->orderBy('Date', 'asc')
                ->get();
            $journal_summary = DB::table('journal')
                ->select(DB::raw('sum(if(ISNULL(Dr),0,Dr)) as Dr'), DB::raw('sum(if(ISNULL(Cr),0,Cr)) as Cr'))
                ->whereBetween('Date', array($request->StartDate, $request->EndDate))
                // ->whereIn('ChartOfAccountID',[110101,110250,110201,110101])
                ->get();
        }

        $sql[0]->Balance = ($sql[0]->Balance == null) ? '0' :  $sql[0]->Balance;

        $data = compact('journal', 'pagetitle', 'sql', 'journal_summary');
        return Excel::download(new LedgerReportExport('general_ledger1pdf', $data), 'General Ledger.xlsx');
    }
}
