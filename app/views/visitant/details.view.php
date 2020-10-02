<html>
    <head>
        <title>{{ $system.appname }} - {{ $title }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?= $this->import('../global/styles') ?>

    </head>
    <body class="text-center">
        <main>
            <form style="max-width:1000px" class="pb-4 mt-4 m-auto">  
                <h4>{{ $visitant.name }}</h4>  
                <br/>
                <input type="hidden" value="{{ $visitant.id }}" id="edit_id" name="edit_id">
                <div class="row m-3">
                    <div class="col-12">
                        <div class="photo">
                            <a href="{{ $system.uri }}/assets/img/visitant/{{ $visitant.photo }}">
                                <img src="{{ $system.uri }}/assets/img/visitant/{{ $visitant.photo }}">
                            </a>
                        </div>
                    </div>    
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <input type="text" value="{{ $visitant.id }}" label="ID" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <input type="text" value="{{ $visitant.lastvisit }}" label="Última visita" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <input type="text" value="{{ $visitant.name }}" label="Nome Completo" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <input type="text" value="{{ $visitant.email }}" label="Email" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <input type="text" value="{{ $visitant.cpf }}" label="CPF" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <input type="text" value="{{ $visitant.rg }}" label="RG" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <input type="text" value="{{ $visitant.birth }}" label="Data de nascimento" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <input type="text" value="{{ $visitant.phone }}" label="Contato" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <input type="text" value="{{ $visitant.company }}" label="Empresa" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <div class="buttons"></div>
                    </div>
                </div>      
            </form>
        </main>
        
        <?= $this->import('../global/dialog_loading') ?>
        <?= $this->import('../global/dialog_message') ?>

        <?= $this->import('../global/scripts') ?>
    </body>
</html>