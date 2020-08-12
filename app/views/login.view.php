<html>
    <head>
        <title>{{system.appname}}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="{{system.uri}}/assets/img/favicon.ico" type="image/x-icon">

        <script src="{{system.uri}}/assets/js/module/forms.mod.js" type="module"></script>

        <link href="{{system.uri}}/assets/css/main.css" rel="stylesheet" type="text/css">
        <link href="{{system.uri}}/assets/css/dialog.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <main>
            <?= $this->include('user/forms/login') ?>
        </main>
        <?= $this->include('global/dialog_loading') ?>
        <?= $this->include('global/dialog_message') ?>
    </body>
</html>