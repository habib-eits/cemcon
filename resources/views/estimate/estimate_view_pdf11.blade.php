<!DOCTYPE html>

<html>



<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Estimate</title>

    <style type="text/css">

        @page {

            margin-top: 100px;

            margin-bottom: 100px;

            margin-left: 0.8cm;

            margin-right: 0.8cm;

        }



        body,

        td,

        th {

            font-size: 11pt;

            font-family: Arial, Helvetica, sans-serif;

        }











        h1,

        h2,

        h3,

        h4 {

            font-weight: bold;

            margin: 0;

        }



        h1 {

            font-size: 16pt;

            margin: 5mm 0;

        }



        h2 {

            font-size: 14pt;

        }



        h3,

        h4 {

            font-size: 9pt;

        }



        ol,

        ul {

 
            margin: 0;

            padding: 0;

        }



        li,

        ul {

            margin-bottom: 0.75em;

        }



        p {

            margin: 0;

            padding: 0;

        }



        p+p {

            margin-top: 1.25em;

        }



        a {

            border-bottom: 1px solid;

            text-decoration: none;

        }



        /* Basic Table Styling */

        table {

            border-collapse: collapse;

            border-spacing: 0;

            /*page-break-inside: always;*/

            border: 0;

            margin: 0;

            padding: 0;

        }



        th,

        td {

            vertical-align: top;

            text-align: left;

        }



        table.container {

            width: 100%;

            border: 0;

        }



        tr.no-borders,

        td.no-borders {

            border: 0 !important;

            border-top: 0 !important;

            border-bottom: 0 !important;

            padding: 0 !important;

            width: auto;

        }



        /* Header */

        table.head {

            margin-bottom: 2mm;

        }



        td.header img {

            max-height: 3cm;

            width: auto;

        }



        td.header {

            font-size: 16pt;

            font-weight: 700;

        }



        td.shop-info {

            width: 40%;

        }



        .document-type-label {

            text-transform: uppercase;

        }



        table.order-data-addresses {

            width: 100%;

            margin-bottom: 0.5mm;

        }



        td.order-data {

            width: 30%;

        }



        .invoice .shipping-address {

            width: 30%;

        }



        .packing-slip .billing-address {

            width: 30%;

        }



        td.order-data table th {

            font-weight: normal;

            padding-right: 2mm;

        }



        table.order-details {

            width: 100%;

            margin-bottom: 8mm;

        }



        .quantity,

        .price {

            width: 10%;

        }



        .product {

            width: 40%;

        }



        .sno {

            width: 3%;

        }



        .order-details tr {

            /* page-break-inside: always;

            page-break-after: auto;*/

        }



        .order-details td,

        .order-details th {

            border-bottom: 1px #ccc solid;

            border-top: 1px #ccc solid;

            padding: 0.375em;

        }



        .order-details th {

            font-weight: bold;

            text-align: left;

        }



        .order-details thead th {

            color: black;

            background-color: #b8b8b8;

            border-color: #b8b8b8;



        }



        .order-details tr.bundled-item td.product {

            padding-left: 5mm;

        }



        .order-details tr.product-bundle td,

        .order-details tr.bundled-item td {

            border: 0;

        }



        dl {

            margin: 4px 0;

        }



        dt,

        dd,

        dd p {

            display: inline;

            font-size: 7pt;

            line-height: 7pt;

        }



        dd {

            margin-left: 5px;

        }



        dd:after {

            content: "\A";

            white-space: pre;

        }



        .customer-notes {

            margin-top: 5mm;

        }



        table.totals {

            width: 100%;

            margin-top: 5mm;

        }



        table.totals th,

        table.totals td {

            border: 0;

            border-top: 1px solid #ccc;

            border-bottom: 1px solid #ccc;

        }



        table.totals th.description,

        table.totals td.price {

            width: 50%;

        }



        table.totals tr:last-child td,

        table.totals tr:last-child th {

            border-top: 2px solid #000;

            border-bottom: 2px solid #000;

            font-weight: bold;

        }



        table.totals tr.payment_method {

            display: none;

        }









        header {

            position: fixed;

            top: -95px;

            left: 0px;

            right: 0px;

            height: auto;

            font-size: 20px !important;

            /*background-color: black;*/

            text-align: center;

            /*border-bottom: 1px solid black;*/



        }



        footer {

            position: fixed;

            bottom: -100px;

            left: 0px;

            right: 0px;

            height: auto;

            font-size: 11px !important;



            border-top: 1px solid black;



            text-align: center;

            padding-top: 0px;



        }

    </style>





</head>



<body>

    <header>



        @if(request()->brancid==1)

        <img src="{{asset('assets/images/header1.jpg')}}" width="100%">

        @else

        <img src="{{asset('assets/images/header2.jpg')}}" width="100%">



        @endif







    </header>







    <footer>

        @if(request()->brancid==1)

        <img src="{{asset('assets/images/footer1.jpg')}}" width="100%">

        @else

        <img src="{{asset('assets/images/footer2.jpg')}}" width="100%">



        @endif





    </footer>





    <table class="head container">

        <tr>

            <td colspan="2" class="header">

                <div align="center">

                    <h2><u>QUOTATION</u></h2>



                </div>

            </td>

        </tr>

    </table>

    <table class="order-data-addresses">

        <tr>

            <td valign="bottom" width="70%">

                <strong>Customer</strong><br>

                <span> {{ $estimate[0]->PartyName }}

                    {{ $estimate[0]->WalkinCustomerName == 1 ? ' -' . $estimate[0]->WalkinCustomerName : ''

                    }}</span><br /><br />

                <!--    @if ($estimate[0]->PartyID != 1)

                    Contact: {{ $estimate[0]->Phone }}<br />

                    Email: {{ $estimate[0]->Email }}<br />

                    TRN: {{ $estimate[0]->TRN }}<br />

                @endif -->

                <table align="right" border="1">

                    <tr class="order-number">

                        <th width="110" style="background-color: #e9e9e9;"><span>Inquiry Date</span></th>

                        <td width="85">

                            <div align="right">{{ dateformatman($estimate[0]->InquiryDate) }}</div>

                        </td>

                    </tr>

                    <tr class="order-date">

                        <th style="background-color: #e9e9e9;"><span>Inquiry No</span></th>

                        <td>

                            <div align="right">{{ $estimate[0]->InquiryNo }}</div>

                        </td>

                    </tr>

                    <tr class="payment-method">

                        <th style="background-color: #e9e9e9;"><span>Company Location </span></th>

                        <td>

                            <div align="right">{{ $estimate[0]->Country }}</div>

                        </td>

                    </tr>

                    <tr class="payment-method">

                        <th style="background-color: #e9e9e9;"><span>Ref No </span></th>

                        <td>

                            <div align="right">{{ $estimate[0]->ReferenceNo }}</div>

                        </td>

                    </tr>

                </table>

                <br />



            </td>

            <td width="30%">



                <br><br>

                <table align="right" border="1">

                    <tr class="order-number">

                        <th width="85" style="background-color: #e9e9e9;"><span>Quotation # </span></th>

                        <td width="120">

                            <div align="right">{{ $estimate[0]->EstimateNo }}</div>

                        </td>

                    </tr>

                    <tr class="order-date">

                        <th style="background-color: #e9e9e9;"><span>Date:</span></th>

                        <td>

                            <div align="right">{{ dateformatman($estimate[0]->Date) }}</div>

                        </td>

                    </tr>

                    <tr class="payment-method">

                        <th style="background-color: #e9e9e9;"><span>Expiry Date :</span></th>

                        <td>

                            <div align="right">{{ dateformatman($estimate[0]->ExpiryDate) }}</div>

                        </td>

                    </tr>



                    <tr class="payment-method">

                        <th style="background-color: #e9e9e9;"><span>Contact: </span></th>

                        <td>

                            <div align="right">Qaiser Shahzad</div>

                        </td>

                    </tr>

                    <tr class="payment-method">

                        <th style="background-color: #e9e9e9;"><span>Email: </span></th>

                        <td>

                            <div align="right">qaiser@cme.ae</div>

                        </td>

                    </tr>

                </table>



                <br><br>

            </td>

        </tr>

        <tr>

            <td colspan="2">

                <div> Our supplies and services are subject to the exclusive application of our general terms and

                    condition of Delivery, Payment and contract supply are as per General Terms and Conditions. <br><br>



                </div>

            </td>

        </tr>



        <tr>

            <td colspan="2" valign="bottom" class="billing-address address"

                style="border: 1px solid black; padding-left: 5px;">



                <table style="font-weight: bold; line-height: 20px;">





                    <tbody>

                        <tr>

                            <td width="200">Equipment User / Plant Site:</td>

                            <td>{{$estimate[0]->EquipmentUser_PlantSite}}</td>

                        </tr>





                        <tr>

                            <td>Vendor / Vendor Reference:</td>

                            <td>{{$estimate[0]->VendorReference}}</td>

                        </tr>



                        <tr>

                            <td>Equipment:</td>

                            <td>{{$estimate[0]->Equipment}}</td>

                        </tr>





                        <tr>

                            <td>Sectional Assembly Group:</td>

                            <td>{{$estimate[0]->SectionalAssemblyGroup}}</td>

                        </tr>

                        <tr>

                            <td>Type:</td>

                            <td>{{$estimate[0]->Type}}</td>

                        </tr>





                        <tr>

                            <td>Origin /Material:</td>

                            <td>{{$estimate[0]->OriginMaterial}}</td>

                        </tr>



                    </tbody>

                </table>

        <tr>

            <td colspan="2" style="padding-top: 15px; line-height: 25px;">

                {!!$estimate[0]->CoveringLetter!!}

                <br><br><br>

            </td>

        </tr>

        </td>

        </tr>

    </table>













    <table width="100%" style="page-break-before: always; border: 1px solid black; border-collapse: collapse;">

        <thead>

            <tr style="background-color: #e9e9e9; border-bottom: 1px solid;">

                <th width="5%" class="sno" style="border-right: 1px solid black; border-left: 1px solid black;">S#</th>

                <th class="product" style="border-right: 1px solid black; border-left: 1px solid black;">Description

                </th>

                <th width="20%" class="quantity"

                    style="border-right: 1px solid black; border-left: 1px solid black; text-align: center;">Qty</th>

                <th width="10%" class="price"

                    style="border-right: 1px solid black; border-left: 1px solid black;text-align: center;">Unit Price

                    <br>(AED)</th>

                <th width="10%" class="price"

                    style="border-right: 1px solid black; border-left: 1px solid black;text-align: center;">Total Price

                    <br> (AED)</th>

            </tr>

        </thead>

        <tbody>









 
            
            <?php 
            $no=1;
             ?>
            @foreach ($estimate_detail as $key => $value)



            <?php if($value->ItemName=='Heading')



           



            ?>



            <tr valign="top">

                <td height="0px" style="border-right: 1px solid black; border-left: 1px solid black; text-align: center;">{{ ($value->UnitQty>0 ) ? $no++ : ''  }}</td>

                <td style="border-right: 1px solid black; border-left: 1px solid black;">

                    @if($value->ItemName=='Heading')



                   

                    {{-- <div style="padding-top: 25px;">



                    </div> --}}



                    <b>{!! $value->Description !!}</b>



                    @elseif($value->ItemName!='Scope')







                    <li

                        style="margin-bottom: 0px; margin-left: 0px;list-style-type: afar; list-style-position: inside;padding-left: 20px;">

                        {!! $value->ItemName !!}</li>



                    @endif



                    @if($value->ItemName=='Scope')



                    {{-- {!! $value->Description !!} --}}

                    <li

                    style="list-style-type: none; list-style-position: inside;padding-left: 40px;font-size:13px">

                    {!! $value->Description !!}</li>



                    @endif





                <td

                    style="border-right: 1px solid black; border-left: 1px solid black; text-align: center; ">

                    @if($value->ItemName != 'Heading' && $value->ItemName != 'Scope')



                    {{ ($value->LS == 'NO') ? number_format($value->UnitQty, 0) .' '. $value->UnitName  : 'L/S' }}



                    @endif



                </td>

                <td

                    style="border-right: 1px solid black; border-left: 1px solid black; text-align: center">

                    @if($value->ItemName != 'Heading' && $value->ItemName != 'Scope')

                    {{-- {{ ($value->LS == 'NO') ? number_format($value->Rate, 0) .' '. $value->UnitName : 'L/S' }} --}}

                    {{ ($value->LS == 'NO') ? number_format($value->Rate, 0) : '' }}



                    @endif </td>

                <td

                    style="border-right: 1px solid black; border-left: 1px solid black;text-align: center;">

                    @if($value->ItemName != 'Heading' && $value->ItemName != 'Scope')

                    {{ number_format($value->Total)}}

                    @endif

                </td>

            </tr>

            @endforeach





            <!--    <?php  for($i = 10; $i>=count($estimate_detail);$i--) { ?>



            <tr>

                <td height="13px"></td>

                <td></td>

                <td></td>

                <td></td>

                <td></td>

                <td></td>

            </tr>



            <?php } ?> -->

        </tbody>

        <tfoot>

            <tr class="no-borders" style="height:30px">

                <td colspan="5" style="border: 1px solid black;">

                    <div style="padding-top: 10px;"><strong>In words </strong>:

                        <em>{{ ucwords(convert_number_to_words($estimate[0]->GrandTotal)) }} only/-</em>

                    </div>









                </td>



            </tr>

        </tfoot>

    </table>



    <table class="noborder" width="35%" style="float: right; margin-top: 20px;">

        <tfoot>

            <tr class="cart_subtotal">

                <td class="no-borders"></td>

                <th class="description">Subtotal</th>

                <td class="price"><span class="totals-price"><span class="amount">

                            {{ number_format($estimate[0]->SubTotal, 2) }}</span></span>

                </td>

            </tr>

            <tr class="order_total">

                <td class="no-borders"></td>

                <th class="description">Dis {{ $estimate[0]->DiscountPer }}%</th>

                <td class="price"><span class="totals-price"><span class="amount">{{

                            number_format($estimate[0]->Discount, 2) }}</span></span>

                </td>

            </tr>

            <tr class="order_total">

                <td class="no-borders"></td>

                <th class="description">Total</th>

                <td class="price"><span class="totals-price"><span class="amount">{{ number_format($estimate[0]->Total,

                            2) }}</span></span>

                </td>

            </tr>

            <!--    <tr class="order_total">

                                <td class="no-borders"></td>

                                <th class="description">Tax @ {{ $estimate[0]->TaxPer }} %</th>

                                <td class="price"><span class="totals-price"><span

                                            class="amount">{{ number_format($estimate[0]->Tax, 2) }}</span></span></td>

                            </tr> -->

            <!--    <tr class="order_total">

                                <td class="no-borders"></td>

                                <th class="description">Shipping</th>

                                <td class="price"><span class="totals-price"><span

                                            class="amount">{{ number_format($estimate[0]->Shipping, 2) }}</span></span>

                                </td>

                            </tr> -->



            <tr class="order_total">

                <td class="no-borders"></td>

                <th class="description">Tax <span style="font-size: 10px;">({{ substr($estimate[0]->TaxType, 3, 10)

                        }})</span>

                </th>

                <td class="price"><span class="totals-price"><span class="amount">{{ number_format($estimate[0]->Tax, 2)

                            }}</span></span>

                </td>

            </tr>





            <!--       <tr class="order_total d-none">

                                <td class="no-borders"></td>

                                <th class="description">Shipping</th>

                                <td class="price"><span class="totals-price"><span

                                            class="amount">{{ number_format($estimate[0]->Shipping, 2) }}</span></span>

                                </td>

                            </tr> -->





            <tr class="order_total">

                <td class="no-borders"></td>

                <th class="description">Grand Total</th>

                <td class="price"><span class="totals-price"><span class="amount">{{

                            number_format($estimate[0]->GrandTotal, 2) }}</span></span>

                </td>

            </tr>



        </tfoot>

    </table>





    <br><br>
    <br><br>
    <br><br>
    <br><br>
 
    <div class="customer-notes"><strong><u>

                <h2>GENERAL TERM & CONDITIONS:</h2>

            </u></strong><br>

        <?php echo $estimate[0]->CustomerNotes; ?>

    </div>

    <div class="customer-notes"><strong><u>

                <h2>PAYMENT TERMS: </h2>

            </u></strong><br>

        <?php echo $estimate[0]->DescriptionNotes; ?>

    </div>




 

    <p style="page-break-before: always;">&nbsp;</p>



    @if(request()->brancid==1)

    <strong>Qaiser Shahzad’</strong><br>

    <img src="{{asset('assets/images/logo-1.jpg')}}">



    <br>

    <strong>CEMCON Middle East LLC </strong><br>



    Dubai, United Arab Emirates.<br>

    Telephone: +971 43303554<br>

    Cell: +971 52 7272 172<br>

    Email: info@cme.ae, Web: www.cme.ae<br>

    <br>

    @else

    <strong>Qaiser Shahzad’</strong><br>

    <img src="{{asset('assets/images/logo-2.jpg')}}">



    <br>

    <strong>CEMCON Mechanical Engineering LLC </strong><br>



    Ajman Industrial Area 2.<Br>

    United Arab Emirates

    .<br>

    Telephone: +971 6 5224700<br>

    Cell: +971 52 727 2172<br>

    Email: info@cme.ae, Web: www.cme.ae<br>

    <br>



    @endif





    <p><strong><u>FORCE MAJEURE:</u></strong></p>



    <p align="justify"> If at any time after the effective date during execution of Order, the performance in whole or

        part of the Purchaser's and/or ours obligation (s) is/are prevented, affected, delayed by reasons of one or more

        of the force majeure events as acts of God, war, civil commotion, sabotage, embargoes, internal unrest, floods,

        explosion, quarantine restrictions, port congestion, seizure or sinking of ships, strikes, lockouts, epidemics,

        earth quake, fire, voltage fluctuation, power cuts and interruptions exceeding 10 days, changes in Governmental

        rules and regulations or omission affecting works, any other conditions beyond our control, when occurring at

        our/our sub-contractor's works and/or at project site, the agreed time of completion of the obligation shall be

        extended. Neither party shall be deemed to be in default of its obligations whilst performance thereof is

        prevented by Force Majeure, and thus the time limits for the performance of such obligation shall accordingly be

        extended by a period equal to that during which the Force Majeure prevails.<br>

    </p>

    <p><strong><u>LIMITATION OF LIABILITY:</u></strong></p>

    <p> We shall under no circumstances be liable for loss of production, loss of profit and other indirect and

        consequential losses.</p>

    <p><strong> <u>DISPUTE RESOLUTION &amp; ARBITRATION:</u></strong></p>

    <p> All the disputes or difference whatsoever arising between the parties out of or relating to the meaning, and/or

        operation of this order and/or breach of order thereof shall be settled through negotiations between both the

        parties, and thereafter in accordance with the UAE Arbitration laws. The courts of UAE shall have exclusive

        jurisdiction</p>

    <script type="text/php">



        if (isset($pdf)) { 

     //Shows number center-bottom of A4 page with $x,$y values

        $x = 520;  //X-axis i.e. vertical position 

        $y = 775; //Y-axis horizontal position

        $text = "Page {PAGE_NUM} of {PAGE_COUNT}";  //format of display message

        $font =  $fontMetrics->get_font("helvetica", "normal");

        $size = 9;

        $color = array(0,0,0);

        $word_space = 0.0;  //  default

        $char_space = 0.0;  //  default

        $angle = 0.0;   //  default

        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);

    }

    

    </script>



</body>



</html>