<html>
    <head>
        <title>{{ $system.appname }} - {{ $title }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <?= $this->import('../global/styles') ?>
    </head>
    <body>

        <div class="row">
            <?= $this->import('../global/header') ?>
        
            <main class="col-sm-12 col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                <div class="content">
                    <h1>{{ $title }}</h1>
                    <?= $this->import($page) ?>
                    <?= $this->import('../global/scripts') ?>
                </div>
            </main>
        </div>

        <?= $this->import('../global/dialog_loading') ?>
        <?= $this->import('../global/dialog_message') ?>
        <?= $this->import('../global/dialog_confirm') ?>

    </body>
</html>