<html>
    <head>
        <title>{{system.appname}} - Error {{error.code}}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="{{system.uri}}/assets/img/favicon.ico" type="image/x-icon">

        <script src="{{system.uri}}/assets/js/module/forms.mod.js" type="module"></script>

        <link href="{{system.uri}}/assets/css/main.css" rel="stylesheet" type="text/css">
        <link href="{{system.uri}}/assets/css/dialog.css" rel="stylesheet" type="text/css">
        <link href="{{system.uri}}/assets/css/forms.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <main>
            <dialog open="open" class="fixed">
                <div>
                    <p><b>{{error.code}}</b>.That’s an error.</p>
                    <p>{{error.message}}</p>
                </div>
            </dialog>
        </main>
        
    </body>
</html>