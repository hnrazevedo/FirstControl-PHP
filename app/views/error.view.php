<html>
    <head>
        <title>{{ $system.appname }} - Error {{ $error.code }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <link href="{{ $system.uri }}/assets/css/main.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/dialog.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/forms.css" rel="stylesheet" type="text/css">

        <style>
            body{
                background-color: rgba(255,0,0,.7) !important;
            }
            body p:first-child{
                text-align: center;
            }
            body p{
                margin:1em;
            }
            hr{
                height: 1px;
                border:none;
                background: rgba(0,0,0,.15) !important;
                width: 80%;
                margin:.5em auto;
            }
        </style>
    </head>
    <body>
        <main>
            <dialog class="fixed open">
                <div>
                    <p><b>{{ $error.code }}</b>. That’s an error.</p>
                    <hr />
                    <p>{{ $error.message }}</p>
                </div>
            </dialog>
        </main>
        
    </body>

    
    <script src="{{ $system.uri }}/assets/js/main.js" type="module"></script>
</html>