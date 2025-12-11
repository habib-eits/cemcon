<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Session;

use DB;

class BookingController extends Controller
{
    // Retrieve all bookings
    public function index()
    {
        // return Booking::all();
        $pagetitle='Booking';
        $booking= DB::table('v_booking')->get();
 
        return view ('booking.booking',compact('booking','pagetitle'));
    }


        public function ajax_booking()
    {
        // return Booking::all();
      if(session::get('Type')=='Admin')
      {

        return DB::table('v_booking')->get();
      }
      else
      {

        return DB::table('v_booking')->where('users_id',session::get('UserID'))->get();
      }

    }


     public function calendar()
    {   
        $pagetitle='Booking';
        return view('calendar.index',compact('pagetitle'));
    }

    // Create a new booking
    public function store(Request $request)
    {

       // dd($request->all());

         $data = array(
            'title' => $request->Title, 
            'start' => $request->Start, 
            'end' => $request->End, 
            'Color' => $request->Color, 
        );

        $booking= DB::table('bookings')->insertGetId($data);






        
         return redirect('calendar');

    }

    // Update an existing booking
    public function update(Request $request)
    {
 
            $data = array(
            'title' => $request->Title, 
            'start' => $request->Start, 
            'end' => $request->End, 
             'Color' => $request->Color, 
        );

        
        
        
        $booking= DB::table('bookings')->where('id', $request->id)->update($data);
        
        

        return redirect('calendar')->with('error','Updated successfully')->with('class','success');
    }

    // Delete a booking
    public function BookingDraged(Request $request)
    {   
           

             $data = array(
            'title' => $request->title, 
            'start' => $request->start, 
            'end' => $request->end, 

            );

        $booking= DB::table('bookings')->where('id' , '=' , $request->id)->update($data);
         
        return redirect('calendar')->with('error','Updated successfully')->with('class','success');
    }
 

    // Delete a booking
    public function destroy($id)
    {
        
        
        $delete = DB::table('bookings')->where('id',$id)->delete();
        
        return redirect()->back()->with('error','Deleted successfully')->with('class','success');


    }


    public function BookingCreate($id)
    {
        $pagetitle='Create Booking';
        $leads = DB::table('leads')->where('id',$id)->get();
        $party = DB::table('party')->get();
        $supplier = DB::table('supplier')->get();
        $user = DB::table('users')->get();
 

        return view ('booking.booking_create',compact('leads','pagetitle','party','supplier','user'));


    }


    public  function BookingSave(request $request)
    {
  
 


              $data = array(
       

              "lead_id" => $request->lead_id,
              "title" => $request->title,
              "start" => $request->start,
              "end" => $request->end,
              "color" => $request->color,
              "agent_name" => $request->agent_name,
              "PartyID" => $request->PartyID,
              "client_contact" => $request->client_contact,
              "client_address" => $request->client_address,
              "SupplierID" => $request->SupplierID,
              "vendor_cost" => $request->vendor_cost,
              "input_vat" => $request->input_vat,
              "cnc_cost" => $request->cnc_cost,
              "output_vat" => $request->output_vat,

              "profit" => $request->profit,
              "net_profit" => $request->net_profit,
              
              "services" => $request->services,
              "payment_status" => $request->payment_status,
              "collected_by" => $request->collected_by,
              "amount" => $request->amount,
              "remarks" => $request->remarks,

              "users_id" => $request->user_id,
 
        );





        if ($request->hasFile('file')) {

            $this->validate($request, [
    
             // 'file' => 'required|mimes:jpeg,png,jpg,gif,svg,xlsx,pdf|max:1000',
               'file' => 'required|file|mimes:jpg,jpeg,png,gif,pdf,docx|max:2048',

                ] );

              $file = $request->file('file');

                $storagePath = 'public/uploads';
                 $path = $file->store($storagePath);
                 $filename_file = basename($path);


            $data = Arr::add($data, 'file',  $filename_file);


        }

         if ($request->hasFile('invoice_file')) {

         $this->validate($request, [
    
         // 'file' => 'required|mimes:jpeg,png,jpg,gif,svg,xlsx,pdf|max:1000',
           'invoice_file' => 'required|file|mimes:jpg,jpeg,png,gif,pdf,docx|max:2048',

            ] );

           $invoice_file = $request->file('invoice_file'); 
           $storagePath = 'public/uploads';
                 $path = $invoice_file->store($storagePath);
                 $filename_invoice = basename($path);


            $data = Arr::add($data, 'invoice_file',  $filename_invoice);

        }
      

      
    

        $booking_id= DB::table('bookings')->insertGetId($data);



        // Journal Entries 

        // 1. A/R

         // A/R -> Debit
        $data_ar = array(
        'VHNO' => 'Booking#'.$booking_id,
        'ChartOfAccountID' => '110400',   //A/R
        'PartyID' => $request->input('PartyID'),
        'BookingID' =>$booking_id, #7A7A7A
        'Narration' => $request->title .' '. $request->services , 
        'Date' => $request->input('start'),
        'Dr' => $request->cnc_cost, 
        'Trace' => 123, // for debugging for reverse engineering
         
        );

        $journal_entry= DB::table('journal')->insertGetId($data_ar);

         
        // 3. sales

         // Sales -> Credit
        $data_sale = array( 
        'VHNO' => 'Booking#'.$booking_id,
        'ChartOfAccountID' => '410100',   //Sales
        'PartyID' => $request->input('PartyID'),
        'BookingID' =>$booking_id, #7A7A7A
        'Narration' => $request->title .' '. $request->services , 
        'Date' => $request->input('start'),
        'Cr' => $request->cnc_cost-$request->output_vat,
        'Trace' => 12345, // for debugging for reverse engineering
         
        );

        $journal_entry= DB::table('journal')->insertGetId($data_sale);

        // 4. Tax -> VAT-OUTPUT TAX -> tax payable

         // VAT-OUTPUT TAX -> Credit

        if($request->input('output_vat')>0) { // if tax item is present in invoice


        $data_vat_out = array(
        'VHNO' =>'Booking#'.$booking_id,
        'ChartOfAccountID' => '210300',   //VAT-OUTPUT TAX ->tax payable
        'PartyID' => $request->input('PartyID'),
        'BookingID' =>$booking_id, #7A7A7A
       'Narration' => $request->title .' '. $request->services , 
        'Date' => $request->input('start'),
        'Cr' => $request->output_vat,
        'Trace' => 12346, // for debugging for reverse engineering

         
        );

        $journal_entry= DB::table('journal')->insertGetId($data_vat_out); 
        }

         


        // when payment is made by party
        if (($request->input('amount')>0) &&($request->collected_by=='CNC'))
        {

        // 5. Cash/Bank ->Debit


        $ChartOfAccountID=($request->payment_status=='Cash') ? 110101 : 110201;   //bank / cash Debit
         
        $data_cash_bank = array(
        'VHNO' =>'Booking#'.$booking_id,
        'ChartOfAccountID' => $ChartOfAccountID,   //bank / cash Debit
        'PartyID' => $request->input('PartyID'),
       'BookingID' =>$booking_id, #7A7A7A
        'Narration' => $request->title .' '. $request->services , 
        'Date' => $request->input('start'),
        'Dr' => $request->input('amount'),
        'Trace' => 1234678, // for debugging for reverse engineering

         
        );

        $journal_entry= DB::table('journal')->insertGetId($data_cash_bank); 


        // 5. Acc Receivable  ->Credit

        $data_ar_credit = array(
        'VHNO' =>'Booking#'.$booking_id,
        'ChartOfAccountID' => '110400',   //A/R credit
        'PartyID' => $request->input('PartyID'),
       'BookingID' =>$booking_id, #7A7A7A
       'Narration' => $request->title .' '. $request->services , 
        'Date' => $request->input('start'),
        'Cr' => $request->input('amount'),
        'Trace' => 1234689, // for debugging for reverse engineering

         
        );

        $journal_entry= DB::table('journal')->insertGetId($data_ar_credit);

      }

   



 
        //purchase entries
        // Journal Entries 

            // 1. stock inventory

            // Stock inventory

            $data_stock_inventory = array(
              'VHNO' =>'Booking#'.$booking_id,
              'ChartOfAccountID' => '510102',   //Stock inventory
              'SupplierID' => $request->input('SupplierID'),
              'BookingID' =>$booking_id, #7A7A7A
              'Narration' => $request->title .' '. $request->services , 
              'Date' => $request->input('start'),
              'Dr' => $request->input('vendor_cost')-$request->input('input_vat'),
              'Trace' => 111, // for debugging for reverse engineering
         
            );

            $journal_entry = DB::table('journal')->insertGetId($data_stock_inventory);


         


        if($request->input('input_vat') >0)
        
{              // 3. TAX ON PURCHASES

            $data_tax_dis = array(
              'VHNO' =>'Booking#'.$booking_id,
              'ChartOfAccountID' => '110800',   // TAX ON PURCHASES
              'SupplierID' => $request->input('SupplierID'),
              'BookingID' =>$booking_id, #7A7A7A
              'Narration' => $request->title .' '. $request->services , 
              'Date' => $request->input('start'),
              'Dr' => $request->input('input_vat'),
              'Trace' => 11112, // for debugging for reverse engineering
         
            );

            $journal_entry = DB::table('journal')->insertGetId($data_tax_dis);
        }

         


                  // 5. Acc Payable  ->credit

              $data_ac_payable = array(
                'VHNO' =>'Booking#'.$booking_id,
                'ChartOfAccountID' => '210100',   // Acc Payable  ->Credit
                'SupplierID' => $request->input('SupplierID'),
                'BookingID' =>$booking_id, #7A7A7A
                'Narration' => $request->title .' '. $request->services , 
                'Date' => $request->input('start'),
                'Cr' => $request->vendor_cost,
                'Trace' => 11114, // for debugging for reverse engineering
         
              );

              $journal_entry = DB::table('journal')->insertGetId($data_ac_payable);



            

            // // when payment is made by us
           if (($request->input('amount')>0) &&($request->collected_by=='Vendor'))

              {


              // 6. Acc Payable  ->Debit

              $data_ap_credit = array(
                'VHNO' =>'Booking#'.$booking_id,
                'ChartOfAccountID' => '210100',   //A/Payable credit
                'PartyID' => $request->input('PartyID'),
                'SupplierID' => $request->input('SupplierID'),
                'BookingID' =>$booking_id, #7A7A7A
                'Narration' => $request->title .' '. $request->services , 
                'Date' => $request->input('start'),
                'Dr' => $request->input('amount'),
                'Trace' => 11116, // for debugging for reverse engineering

         
              );

              $journal_entry = DB::table('journal')->insertGetId($data_ap_credit);


              // 5. Cash/Bank ->Credit




              $data_cash_bank = array(
                'VHNO' =>'Booking#'.$booking_id,
                'ChartOfAccountID' => '110400',   //a/c receiable 
                'PartyID' => $request->input('PartyID'),
                'SupplierID' => $request->input('SupplierID'),
                'BookingID' =>$booking_id, #7A7A7A
                'Narration' => $request->title .' '. $request->services , 
                'Date' => $request->input('start'),
                'Cr' => $request->input('amount'),
                'Trace' => 11115, // for debugging for reverse engineering

               
              );

              $journal_entry = DB::table('journal')->insertGetId($data_cash_bank);



            }


 
     return redirect ('Booking')->with('error', 'booking saved.')->with('class','success');







        
    }


        public  function BookingEdit($id)
        {
             $pagetitle='Create Booking';
            $booking = DB::table('bookings')->where('id',$id)->get();
              $party = DB::table('party')->get();
        $supplier = DB::table('supplier')->get();
        $user = DB::table('users')->get();
              
            
        return view ('booking.booking_edit',compact('booking','pagetitle','party','supplier','user'));
        }






    public  function BookingUpdate1(request $request)
    {
     
                    


      $data = array(
       

              "lead_id" => $request->lead_id,
              "title" => $request->title,
              "start" => $request->start,
              "end" => $request->end,
              "color" => $request->color,
              "agent_name" => $request->agent_name,
              "PartyID" => $request->PartyID,
              "client_contact" => $request->client_contact,
              "client_address" => $request->client_address,
              "SupplierID" => $request->SupplierID,
              "vendor_cost" => $request->vendor_cost,
              "input_vat" => $request->input_vat,
              "cnc_cost" => $request->cnc_cost,
              "output_vat" => $request->output_vat,

              "profit" => $request->profit,
              "net_profit" => $request->net_profit,
              
              "services" => $request->services,
              "payment_status" => $request->payment_status,
              "collected_by" => $request->collected_by,
              "amount" => $request->amount,
              "remarks" => $request->remarks,

              "users_id" => $request->user_id,
 
        );





        if ($request->hasFile('file')) {

            $this->validate($request, [
    
             // 'file' => 'required|mimes:jpeg,png,jpg,gif,svg,xlsx,pdf|max:1000',
               'file' => 'required|file|mimes:jpg,jpeg,png,gif,pdf,docx|max:2048',

                ] );

              $file = $request->file('file');

                $storagePath = 'public/uploads';
                 $path = $file->store($storagePath);
                 $filename_file = basename($path);


            $data = Arr::add($data, 'file',  $filename_file);


        }

         if ($request->hasFile('invoice_file')) {

         $this->validate($request, [
    
         // 'file' => 'required|mimes:jpeg,png,jpg,gif,svg,xlsx,pdf|max:1000',
           'invoice_file' => 'required|file|mimes:jpg,jpeg,png,gif,pdf,docx|max:2048',

            ] );

           $invoice_file = $request->file('invoice_file'); 
           $storagePath = 'public/uploads';
                 $path = $invoice_file->store($storagePath);
                 $filename_invoice = basename($path);


            $data = Arr::add($data, 'invoice_file',  $filename_invoice);

        }
      

      
    

        
        $del = DB::table('journal')->where('BookingID',$request->id)->delete();
        
 

        
        $booking= DB::table('bookings')->where('id', $request->id)->update($data);
        



        // Journal Entries 

        // 1. A/R

         // A/R -> Debit
        $data_ar = array(
        'VHNO' => 'Booking#'.$request->id,
        'ChartOfAccountID' => '110400',   //A/R
        'PartyID' => $request->input('PartyID'),
        'BookingID' =>$request->id, #7A7A7A
        'Narration' => $request->title .' '. $request->services , 
        'Date' => $request->input('start'),
        'Dr' => $request->cnc_cost, 
        'Trace' => 123, // for debugging for reverse engineering
         
        );

        $journal_entry= DB::table('journal')->insertGetId($data_ar);

         
        // 3. sales

         // Sales -> Credit
        $data_sale = array( 
        'VHNO' => 'Booking#'.$request->id,
        'ChartOfAccountID' => '410100',   //Sales
        'PartyID' => $request->input('PartyID'),
        'BookingID' =>$request->id, #7A7A7A
        'Narration' => $request->title .' '. $request->services , 
        'Date' => $request->input('start'),
        'Cr' => $request->cnc_cost-$request->output_vat,
        'Trace' => 12345, // for debugging for reverse engineering
         
        );

        $journal_entry= DB::table('journal')->insertGetId($data_sale);

        // 4. Tax -> VAT-OUTPUT TAX -> tax payable

         // VAT-OUTPUT TAX -> Credit

        if($request->input('output_vat')>0) { // if tax item is present in invoice


        $data_vat_out = array(
        'VHNO' =>'Booking#'.$request->id,
        'ChartOfAccountID' => '210300',   //VAT-OUTPUT TAX ->tax payable
        'PartyID' => $request->input('PartyID'),
        'BookingID' =>$request->id, #7A7A7A
       'Narration' => $request->title .' '. $request->services , 
        'Date' => $request->input('start'),
        'Cr' => $request->output_vat,
        'Trace' => 12346, // for debugging for reverse engineering

         
        );

        $journal_entry= DB::table('journal')->insertGetId($data_vat_out); 
        }

         


        // when payment is made by party
        if (($request->input('amount')>0) &&($request->collected_by=='CNC'))
        {

        // 5. Cash/Bank ->Debit


        $ChartOfAccountID=($request->payment_status=='Cash') ? 110101 : 110201;   //bank / cash Debit
         
        $data_cash_bank = array(
        'VHNO' =>'Booking#'.$request->id,
        'ChartOfAccountID' => $ChartOfAccountID,   //bank / cash Debit
        'PartyID' => $request->input('PartyID'),
       'BookingID' =>$request->id, #7A7A7A
        'Narration' => $request->title .' '. $request->services , 
        'Date' => $request->input('start'),
        'Dr' => $request->input('amount'),
        'Trace' => 1234678, // for debugging for reverse engineering

         
        );

        $journal_entry= DB::table('journal')->insertGetId($data_cash_bank); 


        // 5. Acc Receivable  ->Credit

        $data_ar_credit = array(
        'VHNO' =>'Booking#'.$request->id,
        'ChartOfAccountID' => '110400',   //A/R credit
        'PartyID' => $request->input('PartyID'),
       'BookingID' =>$request->id, #7A7A7A
       'Narration' => $request->title .' '. $request->services , 
        'Date' => $request->input('start'),
        'Cr' => $request->input('amount'),
        'Trace' => 1234689, // for debugging for reverse engineering

         
        );

        $journal_entry= DB::table('journal')->insertGetId($data_ar_credit);

      }

   



 
        //purchase entries
        // Journal Entries 

            // 1. stock inventory

            // Stock inventory

            $data_stock_inventory = array(
              'VHNO' =>'Booking#'.$request->id,
              'ChartOfAccountID' => '510102',   //Stock inventory
              'SupplierID' => $request->input('SupplierID'),
              'BookingID' =>$request->id, #7A7A7A
              'Narration' => $request->title .' '. $request->services , 
              'Date' => $request->input('start'),
              'Dr' => $request->input('vendor_cost')-$request->input('input_vat'),
              'Trace' => 111, // for debugging for reverse engineering
         
            );

            $journal_entry = DB::table('journal')->insertGetId($data_stock_inventory);


         


        if($request->input('input_vat') >0)
        
{              // 3. TAX ON PURCHASES

            $data_tax_dis = array(
              'VHNO' =>'Booking#'.$request->id,
              'ChartOfAccountID' => '110800',   // TAX ON PURCHASES
              'SupplierID' => $request->input('SupplierID'),
              'BookingID' =>$request->id, #7A7A7A
              'Narration' => $request->title .' '. $request->services , 
              'Date' => $request->input('start'),
              'Dr' => $request->input('input_vat'),
              'Trace' => 11112, // for debugging for reverse engineering
         
            );

            $journal_entry = DB::table('journal')->insertGetId($data_tax_dis);
        }

         


                  // 5. Acc Payable  ->credit

              $data_ac_payable = array(
                'VHNO' =>'Booking#'.$request->id,
                'ChartOfAccountID' => '210100',   // Acc Payable  ->Credit
                'SupplierID' => $request->input('SupplierID'),
                'BookingID' =>$request->id, #7A7A7A
                'Narration' => $request->title .' '. $request->services , 
                'Date' => $request->input('start'),
                'Cr' => $request->vendor_cost,
                'Trace' => 11114, // for debugging for reverse engineering
         
              );

              $journal_entry = DB::table('journal')->insertGetId($data_ac_payable);



            

            // // when payment is made by us
           if (($request->input('amount')>0) &&($request->collected_by=='Vendor'))

              {


              // 6. Acc Payable  ->Debit

              $data_ap_credit = array(
                'VHNO' =>'Booking#'.$request->id,
                'ChartOfAccountID' => '210100',   //A/Payable credit
                'PartyID' => $request->input('PartyID'),
                'SupplierID' => $request->input('SupplierID'),
                'BookingID' =>$request->id, #7A7A7A
                'Narration' => $request->title .' '. $request->services , 
                'Date' => $request->input('start'),
                'Dr' => $request->input('amount'),
                'Trace' => 11116, // for debugging for reverse engineering

         
              );

              $journal_entry = DB::table('journal')->insertGetId($data_ap_credit);


              // 5. Cash/Bank ->Credit




              $data_cash_bank = array(
                'VHNO' =>'Booking#'.$request->id,
                'ChartOfAccountID' => '110400',   //a/c receiable 
                'PartyID' => $request->input('PartyID'),
                'SupplierID' => $request->input('SupplierID'),
                'BookingID' =>$request->id, #7A7A7A
                'Narration' => $request->title .' '. $request->services , 
                'Date' => $request->input('start'),
                'Cr' => $request->input('amount'),
                'Trace' => 11115, // for debugging for reverse engineering

               
              );

              $journal_entry = DB::table('journal')->insertGetId($data_cash_bank);



            }



                 return redirect ('calendar')->with('error', 'updates saved.')->with('class','success');




    }

}