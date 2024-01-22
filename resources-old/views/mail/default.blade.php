<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Victorum Capital</title>
    <link
        href="htpps://fonts.googleapis.com/css?family=Open+Sans&display=swap"
        rel="stylesheet"
    />
    <style>
        * {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI",
            Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue",
            sans-serif;
        }

        body {
            background-color: #fff;
            padding: 80px 7%;
        }

        .content-wrapper {
            text-align: center;
            max-width: 500px;
            margin: auto;
        }

        h2 {
            color: #2A5182;
            font-weight: 700;
            font-size: 36px;
            line-height: 40px;
            margin-top: 90px;
        }

        p {
            color: #000;
            font-size: 16px;
            line-height: 20px;
            font-weight: 400;
        }

        .follow-us {
            color: #2A5182;
            font-weight: 600;
            line-height: 24px;
        }

        .link {
            color: #2A5182;
            text-decoration: none;
        }

        .img-box {
            display: flex;
            margin-left: auto;
            margin-right: auto;
            max-width: 180px;
            justify-content: space-between;
        }

        .code {
            color: #2A5182;
            font-size: 39px;
            line-height: 24px;
            font-weight: 700;
            margin-left: auto;
            margin-right: auto;
            max-width: 498px;
        }
        .footer-text {
            text-align: left !important;
            line-height: 30px;
        }
    </style>
</head>
<body>
<div class="content-wrapper">
    <img
        src="https://www.victorum-capital.com/wp-content/uploads/2021/11/Victorum_V2_blue1000px.png"
        alt="logo"
        style="max-width: 300px;"
    />
    @if(isset($name))
        <h2>{{ 'Hello' }} {{$name}}</h2>
    @else
        <h2>{{ $title ?? 'Hello' }}</h2>
    @endif
    @if(isset($align)) 
        <div style="text-align: {{$align}};">
    @endif
    <p>@if(isset($message))
            {!! $message !!}
        @endif</p>
    @if(isset($code))
        <p class="code">{{$code}}</p>
    @endif
    <p class="text-two">@if(isset($message1))
            {!! $message1 !!}
        @endif</p>
    @if(isset($url))
        <a class="link" target="_blank" href="{{$url}}"><strong>{{$button}}</strong></a>
    @endif
    <p class="text-three">
        @if(isset($message2))
            {!! $message2 !!}
        @endif</p>
    <p class="text-four">
        @if(isset($message3))
            {!! $message3 !!}
        @endif
    </p>
    @if(isset($align)) 
        </div>
    @endif
    {{-- <p class="follow-us">{{ 'Follow us on' }}</p> --}}
    {{-- <div class="img-box">
        <div class="img-div">
            <a href="https://t.me/carSale">
                <img src="{{ asset('storage/app_images/telegram.png') }}"
                     alt="Telegram"/>
            </a>
        </div>
        <div class="img-div">
            <a href="https://twitter.com/carSale_">
                <img src="{{ asset('storage/app_images/twitter.png') }}"
                     alt="Twitter"/>
            </a>
        </div>
        <div class="img-div">
            <a href="https://www.youtube.com/channel/UCy4G3W5i3-cwm_5QaPcF1og">
                <img src="{{ asset('storage/app_images/youtube.png') }}"
                     alt="Youtube"/>
            </a>
        </div>
    </div> --}}
    <br>
    <footer>
        <p class="footer-text">@if(isset($footerText))
            {!! $footerText !!}
        @endif</p>
    </footer>
</div>

</body>
</html>
