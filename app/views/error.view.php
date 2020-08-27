<html>
    <head>
        <title>{{ $system.appname }} - Error {{ $error.code }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="{{ $system.uri }}/assets/img/favicon.ico" type="image/x-icon">

        <script src="{{ $system.uri }}/assets/js/module/forms.mod.js" type="module"></script>

        <link href="{{ $system.uri }}/assets/css/main.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/dialog.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/forms.css" rel="stylesheet" type="text/css">

        <style>
            body .background .area{
                background-color: rgba(255,0,0,.7) !important;
            }
            body p:first-child{
                text-align: center;
            }
            body p:last-child{
                margin:1em;
            }
            hr{
                height: 1px;
                border:none;
                background: rgba(0,0,0,.15);
                width: 80%;
                margin:.5em auto;
            }
        </style>
    </head>
    <body>
        <?= $this->include('global/background') ?>
        <main>
            <dialog open="open" class="fixed">
                <div>
                    <p><b>{{ $error.code }}</b>. That’s an error.</p>
                    <hr />
                    <p>{{ $error.message }}</p>
                </div>
            </dialog>
        </main>
        
    </body>
</html>