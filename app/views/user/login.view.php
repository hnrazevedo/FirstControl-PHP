<html>
    <head>
        <title>{{ $system.appname }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?= $this->include('../global/styles') ?>
    </head>
    <body class="text-center center">
        <main>
            <?= $this->include('login.form') ?>
        </main>

        <?= $this->include('../global/dialog_loading') ?>
        <?= $this->include('../global/dialog_message') ?>

        <?= $this->include('../global/scripts') ?>
    </body>
</html>