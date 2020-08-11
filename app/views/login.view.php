<html>
    <head>
        <title>{{system.appname}}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="{{system.uri}}/assets/img/favicon.ico" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
        <script src="{{system.uri}}/assets/js/module/forms.mod.js" type="module"></script>
    </head>
    <body>
        <main>
            <?= $this->include('user/forms/login') ?>
        </main>
    </body>
</html>