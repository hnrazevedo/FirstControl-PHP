<html>
    <head>
        <title>{{ $system.appname }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?= $this->include('global/styles') ?>
    </head>
    <body class="d-flex">
        <div class="row">
            <?= $this->include('global/header') ?>
            <main class="col-sm-12 col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                <div class="content">
                    <h1>{{ $title }}</h1>
                    <?= $this->include($page) ?>
                </div>
            </main>
        </div>
        <?= $this->include('global/scripts') ?>
    </body>
</html>