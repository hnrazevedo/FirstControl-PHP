<dialog id="register_visitant_form">
    <div>    
        <div class="heading">
            <span>Cadastro de novo visitante</span>
        </div>
        <div class="content">
            <form provider="visitant" role="visitantRegister" access="/controller/visitant">
                <div class="row" style="max-width:700px">
                    <div class="col-sm-6  col-md-6">
                        <input type="text" id="new_name" name="new_name" label="Nome Completo" maxlength="50">
                    </div>
                    <div class="col-sm-6  col-md-6">
                        <input type="text" id="new_email" name="new_email" label="Email" maxlength="100">
                    </div>
                    <div class="col-sm-6  col-md-6">
                        <input type="text" id="new_cpf" name="new_cpf" label="CPF" data-mask="###.###.###-##">
                    </div>
                    <div class="col-sm-6  col-md-6">
                        <input type="text" id="new_rg" name="new_rg" label="RG" data-mask="##.###.###-#">
                    </div>
                    <div class="col-sm-6  col-md-6">
                        <input type="text" id="new_birth" name="new_birth" label="Data de nascimento" data-mask="##/##/####" >
                    </div>
                    <div class="col-sm-6  col-md-6">
                        <input type="text" id="new_phone" name="new_phone" label="Celular" data-mask="(##) #####-####" >
                    </div>
                    <div class="col-sm-6  col-md-6">
                        <input type="text" id="new_company" name="new_company" label="Empresa" maxlength="50" >
                    </div>
                    <div class="col-sm-6  col-md-6">
                        <input type="file" id="new_photo" name="new_photo" label="Foto" accept=".jpg,.png" text="Selecione uma foto">
                    </div>
                    <div class="col-12">
                        <div class="buttons">
                            <button class="submit  btn btn-primary">Registrar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</dialog>