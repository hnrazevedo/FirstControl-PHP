<dialog id="register_visitant_form">
    <div>    
        <div class="heading">
            <span>Cadastro de novo visitante</span>
        </div>
        <div class="content">
            <form provider="visitant" role="visitantRegister" access="/controller/visitant">        
                <ul>
                    <li>
                        <input type="text" id="new_name" name="new_name" label="Nome Completo" maxlength="50">
                    </li>
                    <li>
                        <input type="text" id="new_cpf" name="new_cpf" label="CPF" data-mask="###.###.###-##">
                    </li>
                    <li>
                        <input type="text" id="new_rg" name="new_rg" label="RG" data-mask="##.###.###-#">
                    </li>
                    <li>
                        <input type="text" id="new_email" name="new_email" label="Email" maxlength="100">
                    </li>
                    <li>
                        <input type="text" id="new_birth" name="new_birth" label="Data de nascimento" data-mask="##/##/####" >
                    </li>
                    <li>
                        <input type="text" id="new_phone" name="new_phone" label="Celular" data-mask="(##) #####-####" >
                    </li>
                    <li>
                        <input type="text" id="new_company" name="new_company" label="Empresa" maxlength="50" >
                    </li>
                    <li>
                        <input type="file" id="new_photo" name="new_photo" label="Foto" accept=".jpg,.png" text="Selecione uma foto">
                    </li>
                    <li>
                        <div class="buttons">
                            <button class="submit">Registrar</button>
                        </div>
                    </li>
                </ul>   
            </form>
        </div>
    </div>
</dialog>