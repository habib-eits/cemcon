<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobWiseProfitLossController extends Controller
{
    public function JobwiseProfitLoss()
    {
        $pageTitle = 'Jobwise Proft & Loss';
        $jobs = DB::table('job')->get();
        return view('jobwise_profit_loss', [
            'jobs' => $jobs,
            'pageTitle' => $pageTitle
        ]);
    }

    public function JobwiseProfitLossReport(Request $request)
    {
        $pageTitle = 'Jobwise Proft & Loss';
        $jobID = $request->JobID;

        $invoices = collect();
        $expenses = collect();
        $profitLoss = 0;

        if (!empty($jobID)) {
            $invoices = DB::table('invoice_master')
                ->where('JobID', $request->JobID)
                ->where('InvoiceType', 'Invoice')
                ->get();

            $expenses = DB::table('expense_master')
                ->where('JobID', $jobID)
                ->get();

            $totalIncome = $invoices->sum('Total');
            $totalExpense = $expenses->sum('GrantTotal');

            $profitLoss = abs($totalIncome) - abs($totalExpense);
        }

        // dd($invoices);
        return view('jobwise_profit_loss_report', [
            'invoices' => $invoices,
            'expenses' => $expenses,
            'profitLoss' => $profitLoss,
            'pageTitle' => $pageTitle
        ]);
    }
}
