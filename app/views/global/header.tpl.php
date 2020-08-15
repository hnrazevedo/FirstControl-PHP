<link href="{{system.uri}}/assets/css/header.css" rel="stylesheet" type="text/css">
<header>
    <ul>
        <div class="logo">
            <div class="icon"></div>
            <span>FirstControl-PHP</span>
        </div>
                
                
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
                $li.appendChild($a);
                $ul.appendChild($li);
                console.log(1);
            }
        }  


        if(self.fetch) {
            fetch('/get_menu_list',
                {
                    method: 'POST',
                    headers: {'Requested-Method': 'ajax'}
                })
                .then(res => {
                    return res.json();
                })
                .then(post => {
                    mountMenu(post);
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
            xhr.addEventListener('error',function(XMLHttpRequest,textStatus,errorThrown){
                xhrError(XMLHttpRequest,textStatus,errorThrown);
            });
        }      
    });
</script>       