<header class="pr-3 pl-3 pt-2 pb-2">
    <link href="{{ $system.uri }}/assets/css/header.css" rel="stylesheet" type="text/css">
    
    <a href="{{ $system.uri }}/" class="logo align-items-center text-decoration-none text-body">
        <img src="{{ $system.uri }}/assets/img/logo.png" class="m-2 mb-3 mr-4" />
        <h3 class="d-flex">{{ $system.appname }}</h3>
    </a>

    <input type="checkbox" name="main-menu" id="main-menu" class="header">
    <label for="main-menu"><hr/></label>

    <ul class="float-right nav-menu">
        <li class="d-block d-sm-none d-md-none d-lg-none d-xl-none d-xxl-none">
            <a href="#" class="logo">
                <img src="{{ $system.uri }}/assets/img/logo.png" class="m-2" />
                {{ $system.appname }}
            </a>
        </li>

        <?php if(isset($_SESSION['user'])) : ?>
            <li class="d-block d-sm-none d-md-none d-lg-none d-xl-none d-xxl-none">
                <a href="{{ $system.uri }}/usuario/minha-conta">
                    <img src="{{ $system.uri }}/assets/img/user/{{ $user.photo }}" class="mr-3 ml-2"  data-toggle='tooltip' title='Minha conta' /> 
                    {{ $user.name }}
                </a> 
            </li>
            <li>
                <a href="{{ $system.uri }}/" >
                    <i class='bx bxs-dashboard  mr-3 ml-2 mr-sm-0 mr-md-0 mr-sm-0 mr-lg-0 mr-xl-0 mr-xxl-0 ml-sm-0 ml-md-0 ml-sm-0 ml-lg-0 ml-xl-0 ml-xxl-0'></i>Painel principal
                </a>
            </li>
            <li>
                <a href="{{ $system.uri }}/configuracoes">
                    <i class='bx bx-cog  mr-3 ml-2 mr-sm-0 mr-md-0 mr-sm-0 mr-lg-0 mr-xl-0 mr-xxl-0 ml-sm-0 ml-md-0 ml-sm-0 ml-lg-0 ml-xl-0 ml-xxl-0'></i>Configurações
                </a>
            </li>
            <li>
                <a onclick="toggleFullScreen()">
                <i class='bx bx-exit-fullscreen d-none  mr-3 ml-2 mr-sm-0 mr-md-0 mr-sm-0 mr-lg-0 mr-xl-0 mr-xxl-0 ml-sm-0 ml-md-0 ml-sm-0 ml-lg-0 ml-xl-0 ml-xxl-0'></i>
                <i class='bx bx-fullscreen  mr-3 ml-2 mr-sm-0 mr-md-0 mr-sm-0 mr-lg-0 mr-xl-0 mr-xxl-0 ml-sm-0 ml-md-0 ml-sm-0 ml-lg-0 ml-xl-0 ml-xxl-0'></i>
                    Fullscreen
                </a>
            </li>
            <li>
                <a href="{{ $system.uri }}/sair">
                    <i class="bx bx-exit mr-3 ml-2 mr-sm-0 mr-md-0 mr-sm-0 mr-lg-0 mr-xl-0 mr-xxl-0 ml-sm-0 ml-md-0 ml-sm-0 ml-lg-0 ml-xl-0 ml-xxl-0"></i>Sair
                </a>
            </li>
        <?php else: ?>  
            <li>
                <a href="{{ $system.uri }}/">
                    <i class="bx bx-log-in mr-3 ml-2 mr-sm-0 mr-md-0 mr-sm-0 mr-lg-0 mr-xl-0 mr-xxl-0 ml-sm-0 ml-md-0 ml-sm-0 ml-lg-0 ml-xl-0 ml-xxl-0"></i>Acessar
                </a>
            </li>
            <li>
                <a href="{{ $system.uri }}/esqueci-a-senha">
                    <i class="bx bx-revision mr-3 ml-2 mr-sm-0 mr-md-0 mr-sm-0 mr-lg-0 mr-xl-0 mr-xxl-0 ml-sm-0 ml-md-0 ml-sm-0 ml-lg-0 ml-xl-0 ml-xxl-0"></i>Recuperar senha
                </a>
            </li>
        <?php endif; ?>     
    </ul>
</header>


<nav aria-label="breadcrumb">

    <ol class="breadcrumb justify-content-end mb-0">

        <?php if(isset($_SESSION['user'])) : ?>
            <li class="bd-highlight mr-auto">
                <a href="{{ $system.uri }}/usuario/minha-conta" >
                    <img src="{{ $system.uri }}/assets/img/user/{{ $user.photo }}" class="mr-3" data-toggle='tooltip' title='Minha conta' /> 
                </a> 
                {{ $user.name }}
            </li>
        <?php endif; ?>

        <?php if(isset($breadcrumb)) : ?>
            <?php foreach($breadcrumb as $item):  ?>
                <?php if(!isset($item['active'])) : ?>
                <li class="breadcrumb-item align-items-center">
                    <a href="<?= $item['uri'] ?>"><?= $item['text'] ?></a>
                </li>
                <?php else : ?>
                    <li class="breadcrumb-item active align-items-center" aria-current="page"><?= $item['text'] ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </ol>

</nav>

<?php if(isset($_SESSION['alert'])) : ?>
    <div class="alert alert-<?= $_SESSION['alert']['class'] ?>" role="alert">
        <?= $_SESSION['alert']['message'] ?>
        <a class="alert-close">
            <i class='bx bx-x'></i>
        </a>
    </div>
    <?php unset($_SESSION['alert']); ?>
<?php endif; ?>