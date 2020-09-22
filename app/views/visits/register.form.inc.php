<dialog id="register_visit_form">
    <div class="col-lg-10 col-md-12">    
        <div class="heading">
            <span>Cadastro de nova visita</span>
        </div>
        <div class="content">
            <form provider="visit" role="visitRegister" access="/controller/visit">
                
                    <div class="row">
                        <div class="col-sm-4 col-md-3 preview">
                            <div class="col-12">
                                <div class="photo  text-center center">
                                    <img src="/assets/img/icon.placeholder.svg" id="visitantphoto"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8 col-md-9">
                            <div class="row">
                            <div class="col-12">
                                <h6>Visitante</h6>
                            </div>
                            <div class="col-sm-6  col-md-4 align-bottom d-flex align-items-end">
                                <button dialog="#camera" onclick="CamVisitant()" class="btn btn-primary w-100">Tirar foto</button>
                                <input type="hidden" id="new_photo" name="new_photo">
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <input type="text" id="new_cpf" name="new_cpf" label="CPF" data-mask="###.###.###-##" class="visitant">
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <input type="text" id="new_rg" name="new_rg" label="RG" data-mask="##.###.###-#" class="visitant">
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <input type="text" id="new_company" name="new_company" label="Empresa" maxlength="50" class="visitant">
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <input type="text" id="new_name" name="new_name" label="Nome completo" maxlength="50" class="visitant">
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <input type="text" id="new_birth" name="new_birth" label="Data de nascimento" data-mask="##/##/####" class="visitant">
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <input type="text" id="new_phone" name="new_phone" label="Telefone" data-mask="(##) #####-####" class="visitant">
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <input type="text" id="new_email" name="new_email" label="Email" maxlength="100" class="visitant">
                            </div>                            
                        </div>
                        </div>
                    </div>

                <br />

                
                    <div class="row">
                        <div class="col-sm-4 col-md-3 preview">
                            <div class="col-12">
                                <div class="photo  text-center center">
                                    <img src="/assets/img/icon.placeholder.svg" id="carphoto"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8 col-md-9">
                            <div class="row">
                            <div class="col-12">
                                <h6>Veiculo</h6>
                            </div>
                            <div class="col-sm-6  col-md-4 align-bottom d-flex align-items-end">
                                <button dialog="#camera" onclick="CamCar()" class="btn btn-primary w-100">Tirar foto</button>
                                <input type="hidden" id="new_carphoto" name="new_carphoto">
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <input type="text" id="new_board" name="new_board" label="Placa" maxlength="8" class="car">
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <input type="text" id="new_brand" name="new_brand" label="Marca" maxlength="20" class="car">
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <input type="text" id="new_model" name="new_model" label="Modelo" maxlength="20" class="car">
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <input type="text" id="new_color" name="new_color" label="Cor" maxlength="10" class="car">
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <input type="text" id="new_axes" name="new_axes" label="Nº eixos" data-mask="#" class="car">
                            </div>
                        </div>
                        </div>
                    </div> 

                <br/>

                
                
                <div class="row">
                    <div class="col-sm-4 col-md-3"></div>
                    <div class="col-sm-8 col-md-9">
                        <div class="row">
                        <div class="col-12">
                            <h6>Detalhes</h6>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <input type="text" id="new_reason" name="new_reason" label="Razão/Motivo" maxlength="100">
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <input type="text" id="new_responsible" name="new_responsible" label="Responsável" maxlength="50">
                        </div>
                    </div>
                    </div>
                </div>

                <!--<br/>
                
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
                </div> -->

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
<script>
    window.addEventListener('load',function(){
        var form = document.querySelector('form[provider="visit"][role="visitRegister"]');
        
        form.querySelector('input#new_cpf').addEventListener('blur', async evt => {

            if(evt.target.value.length !== parseInt(evt.target.getAttribute('maxlength'))){
                return false;
            }

            let visitant = await Submitter.setUrl('/visitant/json/'+evt.target.value).execute(true);

            if(visitant.error === undefined){
                for(var field in visitant){
                    input = form.querySelector('input#new_'+field+':not([type="file"])');
                    if(input != undefined){
                        input.value = visitant[field];
                        input.setAttribute('value',visitant[field]);
                    }  
                };
            }else{
                form.querySelectorAll('input.visitant:not(#new_cpf)').forEach(input => {
                    input.value = '';
                    input.setAttribute('value','');
                });
            }
        });

        form.querySelector('input#new_board').addEventListener('blur', async evt => {
            if(evt.target.value.length == 0){
                return false;
            }
            let car = await Submitter.setUrl('/car/json/'+evt.target.value).execute(true);

            if(car.error === undefined){
                for(var field in car){
                    input = form.querySelector('input#new_'+field);
                    if(input != undefined){
                        input.value = car[field];
                        input.setAttribute('value',car[field]);
                    }  
                };
            }else{
                form.querySelectorAll('input.car:not(#new_board)').forEach(input => {
                    input.value = '';
                    input.setAttribute('value','');
                });
            }
        });
    });    
</script>


<script>
    function CamVisitant(){
        Cam.requerCam().inputVal('new_photo').previewImg('visitantphoto');
    }
    function CamCar(){
        Cam.requerCam().inputVal('new_carphoto').previewImg('carphoto');
    }
</script>