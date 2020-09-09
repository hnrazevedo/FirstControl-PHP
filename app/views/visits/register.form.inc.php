<dialog id="register_visitant_form">
    <div>    
        <div class="heading">
            <span>Cadastro de nova visita</span>
        </div>
        <div class="content">
            <form provider="visit" role="visitRegister" access="/controller/visit">        
                <ul>
                    <li>
                        <input type="text" id="new_cpf" name="new_cpf" label="CPF Visitante" data-mask="###.###.###-##">
                    </li>
                </ul>
                <hr/>
                <ul>
                    <li>
                        <input type="text" id="new_reason" name="new_reason" label="Razão/Motivo"  maxlength="100">
                    </li>
                    <li>
                        <input type="text" id="new_responsible" name="new_responsible" label="Responsável" maxlength="50">
                    </li>
                    <li>
                        <input type="text" id="new_birth" name="new_birth" label="Data de nascimento" data-mask="##/##/####" >
                    </li>
                    <li>
                        <input type="text" id="new_place" name="new_place" label="Placa veículo" maxlength="8" >
                    </li>
                    <li>
                        <div class="buttons">
                            <button class="submit  btn btn-primary">Registrar</button>
                        </div>
                    </li>
                </ul>   
            </form>
        </div>
    </div>
</dialog>