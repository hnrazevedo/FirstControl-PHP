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
            <a href="{{ $system.uri }}/usuarios/minha-conta">
                <img src="#!" class="mr-3 ml-2" /> 
                {{ $user.name }}
            </a> 
        </li>
        <li>
            <a href="{{ $system.uri }}/administracao/usuarios">
                <i class='bx bx-user  mr-3 ml-2 mr-sm-0 mr-md-0 mr-sm-0 mr-lg-0 mr-xl-0 mr-xxl-0 ml-sm-0 ml-md-0 ml-sm-0 ml-lg-0 ml-xl-0 ml-xxl-0'></i>Usuários
            </a>
        </li>
        <li>
            <a href="#">
                <i class='bx bx-cube-alt  mr-3 ml-2 mr-sm-0 mr-md-0 mr-sm-0 mr-lg-0 mr-xl-0 mr-xxl-0 ml-sm-0 ml-md-0 ml-sm-0 ml-lg-0 ml-xl-0 ml-xxl-0'></i>Módulos
            </a>
        </li>
        <li>
            <a href="{{ $system.uri }}/administracao/configuracoes">
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
                <a href="{{ $system.uri }}/usuarios/minha-conta">
                    <img src="{{ $system.uri }}/assets/img/users/{{ $user.photo }}" class="mr-3" /> 
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

<!--
    <link href="{{ $system.uri }}/assets/css/header.css" rel="stylesheet" type="text/css">
<input type="checkbox" name="main-menu" id="main-menu" class="header">
<label for="main-menu"><hr/></label>
<header class="col-md-3 col-lg-2 d-md-block sidebar">
    <ul>
        <div class="logo">
            <img src="{{ $system.uri }}/assets/img/logo.png" style="width:2em" />
            <span>FirstControl</span>
        </div>

        <div class="sub-title">
            <h4>Usuário</h4>
        </div>
        <li>
            <a>{{ $user.name }}</a>
        </li>

        <hr />

        
        <hr />

        <div class="sub-title <?= (in_array($router['name'],['users','visitant','car','visit'])) ? 'act' : null ?>">
            <h4>Administração</h4>
        </div>
        <li>
            <a href="/admin/users/" <?= ($router['name']==='users') ? 'class="act"' : null ?>>Usuários</a>
        </li>  
        <li>
            <a href="/visitants" <?= ($router['name']==='visitant') ? 'class="act"' : null ?>>Visitantes</a>
        </li>
        <li>
            <a href="/car" <?= ($router['name']==='car') ? 'class="act"' : null ?>>Veículos</a>
        </li>
        <li>
            <a href="/visit" <?= ($router['name']==='visit') ? 'class="act"' : null ?>>Visitas</a>
        </li>

        <hr />

        <div class="sub-title <?= (in_array($router['name'],['report'])) ? 'act' : null ?>">
            <h4>Relatórios</h4>
        </div>
        <li>
            <a href="#" <?= ($router['name']==='report') ? 'class="act"' : null ?>>...</a>
        </li>  

        <hr class="mb-0" />
        
        <li>
            <a href="/config" <?= ($router['name']==='config') ? 'class="act"' : null ?>>Configurações</a>
        </li>  

        <hr class="mb-0" />

        <li>
            <a href="/logout">Sair</a>
        </li>     
    </ul>
    <div class="col-sm-12 col-md-10 col-12 footer text-center">Versão {{ $system.version }}</div>
</header>

<script>
    document.addEventListener('DOMContentLoaded',function(){
        function mountMenu($data)
        {
            var $ul = document.querySelector('header ul');
            for(var $menu in $data){
                if($ul.querySelector('.sub-title.'+$data[$menu]['submenu']) == null){
                    var $submenu = document.createElement('div');
                    $submenu.classList.add('sub-title');
                    $submenu.classList.add($data[$menu]['submenu']);
                    $submenu.innerHTML = '<h4>'+$data[$menu]['submenu']+'</h4>';
                    $ul.appendChild(document.createElement('hr'));
                    $ul.appendChild($submenu);
                }
                var $a = document.createElement('a');
                $a.setAttribute('href',$data[$menu]['url']);
                $a.innerHTML = $data[$menu]['name'];
                var $li = document.createElement('li');
                $li.setAttribute('id',$data[$menu]['id']);
                if("{{ $pageID }}" == $data[$menu]['id']){
                    $li.classList.add('act');
                    $ul.querySelector('.sub-title.'+$data[$menu]['submenu']).classList.add('act');
                }
                $li.appendChild($a);
                $ul.appendChild($li);
            }
        }  


        /*if(self.fetch) {
            fetch('/get_menu_list',
                {
                    method: 'POST',
                    headers: {'Requested-Method': 'ajax'}
                })
                .then(res => {
                    return res.json();
                })
                .then(post => {
                    //mountMenu(post);
                })
                .catch(err => {
                    console.log(err);
                });
        } else {
            var xhr = new XMLHttpRequest();
            xhr.open( "POST", '/get_menu_list' , true );
            xhr.setRequestHeader("Requested-Method", "ajax");
            xhr.addEventListener('load',function(e){
                if(isJson(xhr.response)){
                    response = JSON.parse(String(xhr.response));
                    mountMenu(response);
                }else{
                    console.log(xhr.response);
                }
            });
        }    */  
    });
</script>       
-->