<!DOCTYPE html>
<html>
    <head>
        <style>

            @font-face {
                font-family: 'Helvetica';
                font-weight: normal;
                font-style: normal;
                font-variant: normal;
                src: url(asset('/assets/fonts/FreeSans.ttf')) format('truetype');
            }

            body {
                font-family: 'Helvetica', Arial, sans-serif;
            }

            @page { 
                height: 11in;
                width: 8.5in;
                margin-left: auto;
                margin-right: auto;
            }

            h2, p {
                font-family: 'Helvetica', Arial, sans-serif;
            }

            table {
                width: 100%;
            }

            td {
                vertical-align: top; /* You can use top, middle, bottom, or baseline */
                min-width: 350px;
            }
            .content {
                margin: 0in 0.5in 0.5in 0.5in;
            }
            .logo1 {
                vertical-align: bottom;
            }
            .img1 {
                height: 30px;
            }
            .img2 {
                height: 30px;
               
            }
            .total{
                width: 250px;
                margin: -5px 0 10px 0;
                height: 1px;
                background: black;
            }
            .head-1 {
                font-size: 18px;
                color: #2A5182;
                font-family: 'Helvetica', Arial, sans-serif;
            }
            .head-2 {
                font-size: 14px;
                color: #000;
                font-family: 'Helvetica', Arial, sans-serif;
            }
            .head-3 {
                opacity: 1;
                color: #414042;
                font-size: 14px;
                letter-spacing: -0.39px;
                text-align: left;
            }
            .table-spacing {
                margin-top: 15px;
                margin-bottom: 30px;
            }
            .space-between {
                background: #2A5182;
                border: none;
                width: 100%;
                height: 1px;
            }
            .text-1 {
                font-size: 12px;
                font-family: 'Helvetica', Arial, sans-serif;
                font-weight: 400;
                color: #2A5182;
                letter-spacing: 0.06px
            }
            .text-2 {
                font-size: 10px;
                font-weight: 400;
                line-height: 22.44px;
                color: #414042;
            }
        </style>
    </head>
    
<body>
    <div class="content">
            <table cellpadding="2">
                <tr>
                    <td align="left" class="logo1" height="40px">
                        <img src="https://www.victorum-capital.com/wp-content/uploads/2021/11/Victorum_V2_blue1000px.png" alt="" class="img1">
                    </td>
                </tr>
            </table>
            <br>
            <br>
            <h2 class="head-1">
                Transfer confirmation
            </h2>
            <hr class="space-between">
            <table class="table-spacing">
                <tbody>
                    <tr>
                        @if(isset($transaction['created_at']))
                            <td>
                                <h2 class="head-2">{{ 'Transfer created'}} </h2>
                                <p class="text-1">{{ \Carbon\Carbon::parse($transaction['created_at'])->format('F j, Y H:i:s T') }}</p>
                            </td>
                        @endif
                        {{-- <td>
                            <h2 class="head-2">{{ 'Funded'}} </h2>
                            <p class="text-1">{{ \Carbon\Carbon::parse($transaction['created_at'])->format('F j, Y H:i:s T') }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h2 class="head-2">{{ 'Paid out'}} </h2>
                            <p class="text-1">{{ \Carbon\Carbon::parse($transaction['created_at'])->format('F j, Y H:i:s T') }}</p>
                        </td> --}}
                        @if(isset($transaction['linked_transaction_id']))
                            <td>
                                <h2 class="head-2">{{ 'Transfer'}} </h2>
                                <p class="text-1">{{  $transaction['linked_transaction_id'] }}</p>
                            </td>
                        @endif
                    </tr>
                </tbody>
            </table>
            @if(isset($user))
                <h2 class="head-1">
                    Your details
                </h2>
                <hr class="space-between">
                <table class="table-spacing">
                    <tbody>
                        <tr>
                            @if(isset($user['first_name']) && isset($user['last_name']))
                            <td>
                                <h2 class="head-2">{{ 'Name' }} </h2>
                                <p class="text-1">{{ $user['first_name'] . " " . $user['last_name'] }}</p>
                            </td>
                            @endif
                            <td>
                                <h2 class="head-2">{{ 'Address' }} </h2>
                                <p class="text-1">
                                    {{ $user['city'] ?? '' }} <br>
                                    {{ $user['address'] ?? '' }} <br>
                                    {{ $user['country'] ?? '' }} 
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif
            <h2 class="head-1">
                Transfer overview
            </h2>
            <hr class="space-between">
            <table class="table-spacing">
                <tbody>
                    @if(isset($transaction['quote']))
                        <tr>
                            @if(isset($transaction['quote']['sourceAmount']) && $transaction['quote']['rate'] && $transaction['quote']['sourceCurrency'])
                                <td>
                                    <h2 class="head-2">{{ 'Amount paid by ' . $user['first_name'] . " " . $user['last_name'] }} </h2>
                                    <p class="text-1">{{ number_format($transaction['quote']['sourceAmount'], 2) . ' ' . $transaction['quote']['sourceCurrency'] }}</p>
                                </td>
                            @endif
                            @if(isset($transaction['transfer']) && isset($transaction['transfer']['feeAmount']) && isset($transaction['quote']['sourceCurrency']))
                            <td>
                                <h2 class="head-2">{{ 'Transfer fees' }} </h2>
                                <p class="text-1">{{ 'Total: ' .  number_format($transaction['transfer']['feeAmount'], 2) . ' ' . $transaction['quote']['sourceCurrency'] }}</p>
                            </td>
                            @endif
                        </tr>
                        <tr>
                            @if(isset($transaction['meta']) && isset($transaction['meta']['sourceValue']) && isset($transaction['meta']['sourceValue']))
                                <td>
                                    <h2 class="head-2">{{ 'Amount converted' }} </h2>
                                    <p class="text-1">{{ number_format($transaction['meta']['sourceValue'], 2) . ' ' . $transaction['meta']['sourceCurrency'] }}</p>
                                </td>
                            @endif
                            @if(isset($transaction['quote']['sourceCurrency']) && $transaction['quote']['rate'] && $transaction['quote']['targetCurrency'])
                                <td>
                                    <h2 class="head-2">{{ 'Exchange rate' }} </h2>
                                    <p class="text-1">{{ 1 . ' ' . $transaction['quote']['sourceCurrency'] . " = " . $transaction['quote']['rate'] . ' ' . $transaction['quote']['targetCurrency'] }}</p>
                                </td>
                            @endif
                        </tr>
                    @endif
                    @if (isset($transaction['meta']) && isset($transaction['recipient']))
                        <tr>
                            <td>
                                @if (isset($transaction['recipient']['account_holder']))
                                    <h2 class="head-2">{{ 'Total to ' . $transaction['recipient']['account_holder'] }} </h2>
                                @endif
                                @if (isset($transaction['meta']['targetValue']) && isset($transaction['meta']['targetCurrency']))
                                    <p class="text-1">{{ number_format($transaction['meta']['targetValue'], 2) . ' ' . $transaction['meta']['targetCurrency'] }}</p>
                                @endif
                            </td>
                        </tr>
                    @endif
                   
                </tbody>
            </table>
            @if (isset($transaction['recipient']))
            <h2 class="head-1">
                Sent to
            </h2>
            <hr class="space-between">
            <table class="table-spacing">
                <tbody>
                    <tr>
                        <td>
                            <h2 class="head-2">{{ 'Name' }} </h2>
                            @if(isset($transaction['recipient']['account_holder']))
                                <p class="text-1">{{ $transaction['recipient']['account_holder'] }}</p>
                            @endif
                        </td>
                        <td>
                            <h2 class="head-2">{{ 'Account details' }} </h2>
                            <p class="text-1">
                                @if(isset($transaction['recipient']['iban']))
                                    {{ 'IBAN: ' .  $transaction['recipient']['iban'] }} <br>
                                @endif
                                @if(isset($transaction['recipient']['sort_code']))
                                    {{ 'Sort Code: ' .  $transaction['recipient']['sort_code'] }} <br>
                                @endif
                                @if(isset($transaction['recipient']['account_number']))
                                    {{ 'Account Number: ' .  $transaction['recipient']['account_number'] }} <br>
                                @endif
                            </p>

                        </td>
                    </tr>
                </tbody>
            </table>
            @endif
    </div>
</body>
</html>