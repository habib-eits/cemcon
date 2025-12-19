<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobProfitLossReport extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $job_id = $request->job_id ?? null;
        $fromDate = $request->fromDate ?? date('Y-m-d');
        $toDate = $request->toDate ?? date('Y-m-d');

        $data = [];

        

        $invoices = DB::table('invoice_master')
            ->where('InvoiceType', 'Invoice')
            ->whereNotNull('JobID')
            ->whereBetween('Date',[$fromDate,$toDate])
            ->when($job_id != null, function ($query) use ($job_id) {
                $query->where('JobID', $job_id);
            })
            ->get();

        $expenses = DB::table('expense_master')
            ->leftJoin('job', 'expense_master.JobID', '=', 'job.JobID')  // join with jobs table
            ->leftJoin('supplier', 'expense_master.SupplierID', '=', 'supplier.SupplierID')  // join with suppliers table
            ->whereNotNull('expense_master.JobID')
            ->whereBetween('Date',[$fromDate,$toDate])
            ->when($job_id != null, function ($query) use ($job_id) {
                $query->where('expense_master.JobID', $job_id);
            })
            ->select(
                'expense_master.*',
                'job.JobNo',       // example column from jobs
                'supplier.SupplierName' // example column from suppliers
            )
            ->get();


        $data = [
            'jobId'        => $job_id,
            'totalSales'        => $invoices->sum('GrandTotal'),
            'totalExpenses'     => $expenses->sum('GrantTotal'),
            'profitLoss'   => $invoices->sum('GrandTotal') - $expenses->sum('GrantTotal'),
            'expenses' => $expenses, 
        ];

        
        
        return view('reports.job_profit_loss_report', [
            'pagetitle' => 'Job Profit Loss Report',
            'jobs' => DB::table('job')->get(),
            'data' => $data,
        ]);
    }
}
