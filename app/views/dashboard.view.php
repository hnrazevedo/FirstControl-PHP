<html>
    <head>
        <title>{{ $system.appname }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="{{ $system.uri }}/assets/img/favicon.ico" type="image/x-icon">

        <script src="{{ $system.uri }}/assets/js/main.js" type="module"></script>

        <link href="{{ $system.uri }}/assets/css/main.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/dialog.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/forms.css" rel="stylesheet" type="text/css">
        
        <link href="{{ $system.uri }}/assets/css/dashboard.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <?= $this->include('global/background') ?>
        <?= $this->include('global/header') ?>
        <main>
            <div class="content">
                <h1>Dashboard</h1>
            </div>
        </main>
    </body>
</html>