<?php 

$fontsCustom = "";
$fontMain = "DejaVu Sans, sans-serif";
$fontSecond = "DejaVu Sans, sans-serif";


$footerBank = '<table style="width: 100%;font-size: 9.5px;">
    <tr>
        <td style="width: 33%;"><b>'.$doc->branch->branch_title.'</b></td>
        <td style="width: 33%;"></td>
    </tr>
    <tr>
        <td style="width: 33%;"><b>'.trans('pdf.tax_number', [], $doc->getLanguageCode()).': '.$doc->branch->tax_number.'</b></td>
        <td style="width: 33%;"></td>
    </tr>
    <tr>
        <td style="width: 33%;"><b>'.trans('pdf.vat_id', [], $doc->getLanguageCode()).': '.$doc->branch->vat_id.'</b></td>
        <td style="width: 33%;"></td>
    </tr>
    
    <tr>
        <td style="width: 33%;"><b>'.trans('pdf.register', [], $doc->getLanguageCode()).': '.$doc->branch->register.'</b></td>
        <td style="width: 33%;">'.$doc->branch->bank_name.'</td>
    </tr>
    
    <tr>
        <td style="width: 33%;">'.trans('pdf.bank_address', [], $doc->getLanguageCode()).': '.$doc->branch->bank_address.'</td>
        <td style="width: 33%;">'.trans('pdf.iban', [], $doc->getLanguageCode()).': '.$doc->branch->iban.'</td>
    </tr>
    <tr>
        
        <td style="width: 34%;">'.trans('pdf.phone', [], $doc->getLanguageCode()).'.: '.$doc->branch->phone.'</td>
        <td style="width: 34%;">'.trans('pdf.bic', [], $doc->getLanguageCode()).': '.$doc->branch->bic.'</td>
    </tr>
    <tr>
        
        <td style="width: 34%;">'.trans('pdf.invoice_fax', [], $doc->getLanguageCode()).'.: '.$doc->branch->fax.'</td>
        <td style="width: 34%;">'.$doc->branch->branch_title.'</td>
    </tr>
    <tr>
        <td style="width: 34%;">'.trans('pdf.invoice_email', [], $doc->getLanguageCode()).': '.$doc->branch->mail.'</td>
        <td style="width: 33%;">'.$doc->branch->web.'</td>
    </tr>
</table>';

$strItems = "";
$count = 0;
$total = 0;
$item_total_without_vat = 0;
foreach($doc->orderItems as $item){
    $count++;
    $strExtra = "";
    $item_quantity = $item->qty;
    $item_price = $item->price;

    $strVatValue = $doc->vat;
    $item_total = ($item_quantity) * ($item_price + $item_price * ($doc->vat/100));
    $item_total_without_vat = $item_total_without_vat + ($item_quantity * $item_price);

    $total = $total + $item_total;
    $strItems .= '<tr class="tr-columns">
                                                    <td class="text-center">' . $count . '</td>
                                                    <td><b>' . $item->product->name . '</b><br>' . nl2br($item->product->description) . '<br>' . $strExtra . '</td>
                                                    <td align="center" class="text-right">' . $item_quantity . ' </td>
                                                    <td align="right" class="text-right"> ' . number_format($item_price, 2, ",", ".") . ' ' . $currency . '  </td>
                                                    <td align="right" class="text-right"> ' . $strVatValue . '% </td>
                                                    <td align="right" class="text-right"> ' . number_format($item_total, 2, ",", ".") . ' ' . $currency . ' </td>
                                                </tr>';
}
$strDiscount = "";
if ($doc->rabat > 0) {

     
    $discount = ($item_total_without_vat) * ($doc->vat * ($doc->vat/100));
    $strDiscount = "<p>" . $discount_text . "(" . $doc->rabat . "%): " . $currency . $discount . "</p>";
}

$output ='<!DOCTYPE html>
<html>
<head>
<style>
    '.$fontsCustom.'
body, html {
    font-family:'.$fontMain.'
    color: #3e5569;
    color: var(--paper-grey-900);
    font-size:8px;
}
.font {
    ' . $fontText . '
    
}
table, tr, th, td {
    border: none;
    border-collapse: collapse;
    color:#3e5569;
}
.th-columns th {
    padding: 8px;
    font-size: 8pt;
    background: #3A68B0;
    color:#FFF;
    font-family:'.$fontMain.';
    border: none;
}
.tr-columns td {
    padding: 8px;
    font-size: 8pt;
    font-family:'.$fontMain.';
}
.tr-columns {
    border-bottom: 1px solid #CCC;
}
.no-border {
    border: none;
}
.table {
    margin-bottom: 20px;
}
.sub-total, .paragraph {
    font-size: 9pt;
    font-family:'.$fontMain.';
    color: #3e5569;
}
.total {
    font-size: 10pt;
    font-family:'.$fontMain.';
    color: #3e5569;
}
hr {
    background: #CCC;
    color: #CCC;
    height: 1px;
}
.middle-heading {
    font-size: 11pt;
    font-family:'.$fontMain.';
    color: #3e5569;
}
.text {
    font-size: 9pt;
    font-family:'.$fontMain.';
    color: #3e5569;
}
.text-gray {
    font-size: 9pt;
    font-family:'.$fontMain.';
    color: #a1aab2;
}
.link {
    font-size: 9pt;
    font-family:'.$fontMain.';
    color: #3A68B0;
} 
.padding-top {
    padding-top: 20px;
}
.gray-box {
    background: #EFEFEF;
    padding: 0 10px;
    font-size: 9pt;
    color: #3e5569;
}
.heading-orange {
    font-size: 11pt;
    font-family:'.$fontMain.';
    color: #3A68B0;
}
.heading {
    font-size: 12pt;
    font-family:'.$fontMain.';
    color: #3e5569;
}
.paragraph{
    display:block;
    padding:0;
    margin:0;
}
.star-ratings{
    display:block;
}
</style>
</head>
<body>
    <center>
<table width="100%" class="font">
    <tr>
        <td style="padding: 15px;padding-top:0px; padding-bottom:0px;font-family: "'.$fontSecond.'", sans-serif;">
        <table width="100%">
        <tr>
        <td style="padding-bottom: 15px;" width="100%">
            <table width="100%">
                <tr>
                    <td align="left" valign="top" width="33.3%">

                            <h3 class="heading-orange"><b>'.$doc->branch->branch_title.'</b></h3>
                            ' . $strAddressD . '

                    </td>
                    <td align="center" valign="top" width="33.3%">
                        <h3 class="heading" align="center" style="text-align:center;"><b>'.trans('pdf.invoice_title', [], $doc->getLanguageCode()).'</b></h3>
                    </td>

                    <td align="right" valign="top" width="33.3%">
                        <img width="150" src="'.public_path("/assets/img/cms/logo-buss.png").'" alt="">
                    </td>
                </tr>
            </table>
        </td>
        </tr>
        </table>
        </td>
    </tr>
</table>
<table width="100%" class="font">
    <tr>
        <td style="padding: 15px;padding-top:0px; padding-bottom:0px;font-family: "'.$fontSecond.'", sans-serif;">
			<table width="100%;">
                <tr>
                    <td width="32%" style="padding-right:0.25%;" valign="top">
                    <table width="100%" height="100%">
                        <tr>
                            <td valign="top" class="gray-box" width="90%" height="110px">
                                <div style="height:110px; overflow:hidden">
                                    <h4 class="text">'.trans('pdf.consignee', [], $doc->getLanguageCode()).'</h4>
                                    <p class="text">' . $company . '
                                        <br/> ' . $address . '
                                        <br/> ' . $postal . ' ' . $city . '</p> 
                                </div> 
                            </td>
                        </tr>
                    </table>
                    </td>
                    <td width="32%" valign="top">
                    <table width="100%" height="100%">
                        <tr>
                        <td valign="top" class="gray-box" width="90%" height="110px">
                            <div style="height:110px; overflow:hidden">
                                <h4 class="text">'.trans('pdf.contact', [], $doc->getLanguageCode()).'</h4>
                                <p class="text">' . $display_name . '</p>
                            </div>
    
                        </td>
                        </tr>
                    </table>
                    </td>
                    <td width="32%" style="pading-left:0%;"  valign="top" align="right">
                    <table width="100%" height="100%">
                        <tr>
                        <td valign="top" class="gray-box" width="90%" height="110px">
                            <div style="height:110px; overflow:hidden">
                                <h4 class="text"><b>'.trans('pdf.invoice_number', [], $doc->getLanguageCode()).'</b></h4>
                                <p class="text"><span class="pull-right">' . $order_number . '</span><br><b style="font-size:6pt;">'.trans('pdf.invoice_date', [], $doc->getLanguageCode()).' :</b> <img src="'.public_path("/assets/img/cms/calendaricon.png").'" alt="star" width="7pt"> ' . $date . '</p>
                            </div>
                        </td>
                        </tr>
                    </table>
                    </td>
                </tr>
            </table>

            <table width="100%;">
                <tr>
                    <td align="left" class="text" style="font-size: 18px;font-weight:bold;">
                        '.trans('pdf.invoice_number_title', [], $doc->getLanguageCode()).' '.$order_number.'
                        
                    </td>
                </tr>
                <tr>
                    <td align="left" class="text">
                        
                        '.trans('pdf.invoice_pdf_line_1', [], $doc->getLanguageCode()).'<br><br>
                    </td>
                </tr>
            </table>
            
            <table class="table" width="100%;">
                <thead class="thead">
                    <tr class="th-columns">
                        <th align="center" style="background: #3A68B0;color:#FFF;padding:5px;font-size:9ptborder:1px solid #3A68B0;">#</th>
                        <th>'.trans('pdf.description', [], $doc->getLanguageCode()).'</th>
                        <th align="right">'.trans('pdf.qty', [], $doc->getLanguageCode()).'</th>
                        <th align="right">'.trans('pdf.price', [], $doc->getLanguageCode()).'</th>
                        <th class="text-right" align="right">' . $strVatText . '</th>
                        <th class="text-right" align="right">'.trans('pdf.sum', [], $doc->getLanguageCode()).'</th>
                    </tr>
                </thead>
                <tbody>
                    ' . $strItems . '
                    
                </tbody>
            </table>

            <table width="100%;" align="right">
                <tr class="col-md-12">
                    <td align="right">
                        ' . $strDiscount . '
                        <hr>
                        <h3 class="total"><b>'.trans('pdf.invoice_sum', [], $doc->getLanguageCode()).':</b> ' . number_format($total, 2, ",", ".") . $currency . '</h3>
                    </td>
                    <div class="clearfix"></div>
                    <hr>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="width: 100%;font-size: 12px;font-weight:bold;">
    <tr>
        <td style="width: 33%;">'.trans('pdf.account_holder', [], $doc->getLanguageCode()).':</td>
        <td style="width: 33%;">'.$doc->branch->branch_title.'</td>
        <td style="width: 33%;"></td>
    </tr>
    <tr>
        <td style="width: 33%;">'.trans('pdf.bank', [], $doc->getLanguageCode()).':</td>
        <td style="width: 33%;">'.$doc->branch->bank_name.'</td>
        <td style="width: 33%;"></td>
    </tr>
    <tr>
        <td style="width: 33%;">'.trans('pdf.iban', [], $doc->getLanguageCode()).':</td>
        <td style="width: 33%;">'.$doc->branch->iban.'</td>
        <td style="width: 33%;"></td>
    </tr>
    <tr>
        <td style="width: 33%;">'.trans('pdf.bic_swift', [], $doc->getLanguageCode()).':</td>
        <td style="width: 33%;">'.$doc->branch->bic.'</td>
        <td style="width: 33%;"></td>
    </tr>
</table>
<br>
<b style="font-size: 13px;text-decoration:underline;">'.trans('pdf.payment_terms', [], $doc->getLanguageCode()).'</b>
<br><br>


' . $footerBank . '
<br>

</td>
</tr>
</table>

</center>
</body>
</html>';

echo $output;