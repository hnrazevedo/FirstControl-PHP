<dialog id="register_visitant_form">
    <div>    
        <div class="heading">
            <span>Cadastro de nova visita</span>
        </div>
        <div class="content">
            <form provider="visit" role="visitRegister" access="/controller/visit">
                <div class="row">
                    <div class="col-sm">
                        <h6>Visitante</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <input type="text" id="new_cpf" name="new_cpf" label="CPF" data-mask="###.###.###-##">
                    </div>
                    <div class="col-sm">
                        <input type="text" id="new_rg" name="new_rg" label="RG" data-mask="##.###.###-#">
                    </div>
                    <div class="col-sm">
                        <input type="text" id="new_company" name="new_company" label="Empresa">
                    </div>
                </div>  
                <div class="row">
                    <div class="col-sm">
                        <input type="text" id="new_name" name="new_name" label="Nome completo" >
                    </div>
                    <div class="col-sm">
                        <input type="text" id="new_bitrh" name="new_bitrh" label="Data de nascimento" data-mask="##/##/####" >
                    </div>
                    <div class="col-sm">
                        <input type="text" id="new_phone" name="new_phone" label="Telefone" data-mask="(##) #####-####">
                    </div>
                </div>   
                <div class="row">
                    <div class="col-4">
                        <input type="text" id="new_email" name="new_email" label="Email" >
                    </div>
                </div>

                <br />
                
                <div class="row">
                    <div class="col-sm">
                        <h6>Veiculo</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <input type="text" id="new_board" name="new_board" label="Placa">
                    </div>
                    <div class="col-sm">
                        <input type="text" id="new_brand" name="new_brand" label="Marca">
                    </div>
                    <div class="col-sm">
                        <input type="text" id="new_model" name="new_model" label="Modelo" >
                    </div>
                </div>  
                <div class="row">
                    <div class="col-4">
                        <input type="text" id="new_color" name="new_color" label="Cor" >
                    </div>
                    <div class="col-4">
                        <input type="text" id="new_axes" name="new_axes" label="Eixos" >
                    </div>
                </div>

                <br/>
                
                <div class="row">
                    <div class="col-sm">
                        <h6>Pesagem</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <input type="text" id="new_weightinit" name="new_weightinit" label="Peso inicial">
                    </div>
                    <div class="col-sm">
                        <input type="text" id="new_weightfinal" name="new_weightfinal" label="Peso final">
                    </div>
                    <div class="col-sm">
                        <input type="text" id="new_nf" name="new_nf" label="Nota Fiscal">
                    </div>
                </div>  

                <div class="row">
                    <div class="col-sm">
                        <div class="buttons">
                            <button class="submit  btn btn-primary">Registrar</button>
                        </div>
                    </div>
                </div> 
            </form>
        </div>
    </div>
</dialog>