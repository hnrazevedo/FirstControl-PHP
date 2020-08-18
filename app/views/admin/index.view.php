<html>
    <head>
        <title>{{system.appname}} - {{title}}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="{{system.uri}}/assets/img/favicon.ico" type="image/x-icon">
        
        <script src="{{system.uri}}/assets/addons/vanilla-datatables/vanilla-dataTables.min.js"></script>
        <link href="{{system.uri}}/assets/addons/vanilla-datatables/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">

        <script src="{{system.uri}}/assets/js/module/forms.mod.js" type="module"></script>
        <script src="{{system.uri}}/assets/js/module/datatable.mod.js" type="module"></script>
        <script src="{{system.uri}}/assets/js/mask.js" ></script>

        <link href="{{system.uri}}/assets/css/main.css" rel="stylesheet" type="text/css">
        <link href="{{system.uri}}/assets/css/dialog.css" rel="stylesheet" type="text/css">
        <link href="{{system.uri}}/assets/css/forms.css" rel="stylesheet" type="text/css">
        <link href="{{system.uri}}/assets/css/datatables.css" rel="stylesheet" type="text/css">

    </head>
    <body>
        <?= $this->include('../global/background') ?>
        <?= $this->include('../global/header') ?>
        <main>
            <div class="content">
                <h1>{{title}}</h1>
            </div>
            <div class="content">
                <?= $this->include($page) ?>
            </div>
        </main>
        <?= $this->include('../global/dialog_loading') ?>
        <?= $this->include('../global/dialog_message') ?>
    </body>
</html>