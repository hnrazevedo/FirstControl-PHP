<html>
    <head>
        <title>{{ $system.appname }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <script src="{{ $system.uri }}/assets/js/main.js" type="module"></script>

        <link href="{{ $system.uri }}/assets/css/main.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/dialog.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/forms.css" rel="stylesheet" type="text/css">

        <link href="{{ $system.uri }}/assets/css/dashboard.css" rel="stylesheet" type="text/css">

        <script src="{{ $system.uri }}/assets/addons/bootstrap/popper.min.js"></script>
    </head>
    <body>
        <div class="row">
            <?= $this->include('global/header') ?>
            <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                <div class="content">
                    <h1>Dashboard</h1>
                </div>
            </main>
        </div>
        <link rel="stylesheet" href="{{ $system.uri }}/assets/addons/bootstrap/bootstrap.min.css">
        <script src="{{ $system.uri }}/assets/addons/bootstrap/bootstrap.min.js"></script>
    </body>
</html>