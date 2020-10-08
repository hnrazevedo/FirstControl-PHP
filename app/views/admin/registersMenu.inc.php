<br />
<div class="row justify-content-center">

    <?php if(isset($addable)) : ?>
        <div class="col col-12 col-xl-2 col-md-3 col-sm-4 mb-2">
            <div class="card bg-dark h-100">
                <a href="{{ $system.uri }}/{{ $addable.uri }}" class="text-white text-center dashboard d-flex align-items-center">
                    <div class="card-body">
                        <p class="icon text-center">
                            <i class='bx bx-plus' ></i>
                        </p>
                        <p class="card-text">{{ $addable.text }}</p>
                    </div>
                </a>
            </div>
        </div>
    <?php endif; ?>
    

    <div class="col col-12 col-xl-2 col-md-3 col-sm-4 mb-2">
        <div class="card bg-dark h-100">
            <a href="{{ $system.uri }}/administracao/registros/{{ $entity }}/listagem" class="text-white text-center dashboard d-flex align-items-center">
                <div class="card-body">
                    <p class="icon text-center">
                        <i class="bx bx-file"></i>
                    </p>
                    <p class="card-text">Registros</p>
                </div>
            </a>
        </div>
    </div>

</div>