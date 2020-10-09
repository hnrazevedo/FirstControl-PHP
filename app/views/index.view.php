<html>
    <head>
        <title>{{ $system.appname }} <?php echo (isset($title)) ? '-' : '' ?> {{ $title }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?= $this->import('global/styles') ?>
    </head>
    <body>
        <?= $this->import('global/header') ?>
            
        <main class="row pb-5">
            <h3 class="m-4 w-auto">{{ $title }}</h2>   
            <div class="col-12 px-4 content">    
                <?= $this->import($page) ?>
            </div>
        </main>
        
        <?= $this->import('global/footer') ?>
        
        <?= $this->import('global/dialog_loading') ?>
        <?= $this->import('global/dialog_message') ?>

        <?= $this->import('global/scripts') ?>
    </body>
</html>