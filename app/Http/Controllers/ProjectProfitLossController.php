<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectProfitLossController extends Controller
{
    public function ProjectProfitAndLoss()
    {
        $pagetitle = 'Proft & Loss';

        $jobs = DB::table('job')
            ->select('JobID', 'JobNo')
            ->orderBy('JobNo')
            ->get();

        return view('jobwise_profitloss', compact('pagetitle', 'jobs'));
    }

    public function ProjectProfitAndLoss1(Request $request)
    {
        $pagetitle = 'Profit & Loss';
        $jobId = $request->JobID;

        $invoices = DB::table('invoice_master')
            ->where('InvoiceType', 'Invoice')
            ->whereNotNull('JobID')
            ->when($jobId != null, function ($query) use ($jobId) {
                $query->where('JobID', $jobId);
            })
            ->get();

        $expenses = DB::table('expense_master')
            ->whereNotNull('JobID')
            ->when($jobId != null, function ($query) use ($jobId) {
                $query->where('JobID', $jobId);
            })
            ->get();

        $data = [
            'pagetitle'    => $pagetitle,
            'jobId'        => $jobId,
            'sales'        => $invoices->sum('GrandTotal'),
            'expenses'     => $expenses->sum('GrantTotal'),
            'profitLoss'   => $invoices->sum('GrandTotal') - $expenses->sum('GrantTotal'),
            'expensesData' => $expenses, 
        ];

        return view('jobwise_profitloss1', $data);
    }

    
    /*
    public function ProjectProfitAndLoss1(Request $request)
    {
        $pagetitle = 'Profit & Loss';

        $jobId = $request->JobID;

        $salesQuery = DB::table('invoice_master')
            ->where('InvoiceType', 'Invoice');

        if ($jobId) {
            $salesQuery->where('JobID', $jobId);
        }

        $totalSales = $salesQuery->sum('GrandTotal');

        $expenseListQuery = DB::table('expense_master')
            ->select(
                'ExpenseNo',
                'ReferenceNo',
                'GrantTotal',
                'JobID'
            );

        if ($jobId) {
            $expenseListQuery->where('JobID', $jobId);
        }

        $expenseList = $expenseListQuery->get();

        $totalExpenses = $expenseList->sum('GrantTotal');

        $profitOrLoss = $totalSales - $totalExpenses;

        return view('jobwise_profitloss1', compact(
            'pagetitle',
            'jobId',
            'totalSales',
            'expenseList',
            'totalExpenses',
            'profitOrLoss'
        ));
    }
    */
}
