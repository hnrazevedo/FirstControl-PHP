<html>
    <head>
        <title>{{ $system.appname }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?= $this->import('../global/styles') ?>
    </head>
    <body class="text-center center">
        <main>
            <?= $this->import('login.form') ?>
        </main>

        <?= $this->import('../global/dialog_loading') ?>
        <?= $this->import('../global/dialog_message') ?>

        <?= $this->import('../global/scripts') ?>
    </body>
</html>