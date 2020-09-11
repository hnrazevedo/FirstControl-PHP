<link href="{{ $system.uri }}/assets/css/header.css" rel="stylesheet" type="text/css">
<header class="col-md-2 d-none d-md-block bg-light sidebar">
    <ul>
        <div class="logo">
            <img src="{{ $system.uri }}/assets/img/logo.png" style="width:2em" />
            <span>FirstControl</span>
        </div>

        <div class="sub-title">
            <h4>Sistema</h4>
        </div>
        <li>
            <a href="/visit">Visitas</a>
        </li>

        <hr>

        <div class="sub-title">
            <h4>Cadastros</h4>
        </div>
        <li>
            <a href="/admin/users">Usuários</a>
        </li>  
        <li>
            <a href="/visitants">Visitantes</a>
        </li>
        <li>
            <a href="/car">Veículos</a>
        </li>


        <li>
            <a href="/logout">Sair</a>
        </li>     
                
    </ul>
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