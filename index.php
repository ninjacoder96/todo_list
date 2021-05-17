<?php 
    require_once('views/layouts/header.php');
    include "./Db/Config.php";
    include "./Db/Factory.php";
    include "./Db/Adapter/AdapterInterface.php";
    include "./Db/Adapter/Pdo.php";
    require 'vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader('views');
    $twig = new \Twig\Environment($loader);

    
    
    $config =  new \Db\Config();
    $db =  \Db\Factory::connect($config);

    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $perPage = 5; 
    $startAt = $perPage * ($currentPage - 1);

    $count = $db->count("SELECT COUNT(*) FROM tasks");


    $users = $db->fetchAll("SELECT * FROM tasks limit  $startAt, $perPage",[
        'column1' => $currentPage,
        'column2' => $perPage,   
    ]);

    $totalItems = count($users); // total items
    $totalPages = ceil($count / $perPage);


    echo $twig->render('data.twig', [
        'currentFilters' => [],
        'data'=> $users,
        'currentPage' => $currentPage,
        'lastPage' =>  $totalPages,
        'paginationPath' => 'index.php'
    ]);


?>
<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal_content">
        <div class="modal_header">
            <span class="close">&times;</span>
            <h2 id="modal_header_title">Modal Header</h2>
        </div>
        <div class="modal_body">
            <form method="POST" id="actionListForm">
                <div class="message" id="message"></div>
                <label>Title</label>
                <input type="text" name="title" id="title">

                <label>Description</label>
                <input type="text" name="title" id="description"/>

                <input type="hidden" name="action" id="action" value=""/>
                <input type="hidden" name="id" id="id"/>
                <div class='spinner'></div>
                <input type="submit" value="" class="button" id="submit_btn"/>
            </form>
        </div>
        <div class="modal_footer">
            <h3>Modal Footer</h3>
        </div>
    </div>

</div>

<script>
    var modal = document.getElementById("myModal");
    var span = document.getElementsByClassName("close")[0];

    const editBtnListener = document.querySelectorAll('.edit_button');

    editBtnListener.forEach(el => el.addEventListener('click', event => {
        modal.style.display = "block";
        
        document.getElementById('modal_header_title').innerHTML = 'Edit Record';

        if(!document.getElementById("update_btn")){
            var editBtn = document.getElementById('submit_btn').id = 'update_btn';
            document.getElementById('update_btn').value = 'UPDATE';
        }
        
        var action = document.getElementById('action').value = 'find_list';

        var id = event.target.getAttribute('data-id');

        const _url = 'Controllers/TodoList.php';
        let _body = {
            action,
            id
        };
        const _headers = {
        'Content-type': 'application/json; charset=UTF-8',
        };
        const _options = { method: 'POST', headers: _headers, body: JSON.stringify(_body) };
        fetch(_url, _options).then((response) => {
            return response.json();
        }).then((response) =>{
            document.getElementById('title').value          = response.data.title;
            document.getElementById('description').value    = response.data.description;
            document.getElementById('id').value             = response.data.id;
            document.getElementById('action').value         = 'update_list';
        });
    }));

    var form = document.getElementById("actionListForm");

    form.addEventListener('submit', async(e) => handleForm(e));

    async function handleForm(event) { 
        event.preventDefault(); 

        document.getElementById('message').innerHTML = '';
        let erListExist = document.querySelector('.errorList');
        if(erListExist){
            erListExist.remove();
        }
        
        if(document.getElementById('action').value == 'update_list'){
            
            var update_btn  = document.getElementById('update_btn');
            update_btn.style.display = 'none';
            var spinner = document.querySelector('.spinner');
            spinner.classList.add('loading');
            let id              =   document.getElementById('id').value;
            let title           =   document.getElementById('title').value;
            let desc            =   document.getElementById('description').value;
            let action          =   document.getElementById('action').value;
            const _url = 'Controllers/TodoList.php';
            let _body = {
                id: id,
                title: title,
                desc: desc,
                action: action,
            };
            const _headers = {
            'Content-type': 'application/json; charset=UTF-8',
            };
            const _options = { method: 'POST', headers: _headers, body: JSON.stringify(_body) };


            await fetch(_url, _options).then((response) => {
                return response.json();
            }).then((res) => {
                spinner.classList.remove('loading');
                update_btn.style.display = 'block';

                if(res.status == 'failed'){
                    var erList = document.createElement("ul");
                    erList.className = 'errorList';
                    document.body.appendChild(erList);

                    for (let i = 0; i < res.msg.length; i++) {
                        var li = document.createElement("li");  
                        li.innerHTML  = res.msg[i];
                        erList.appendChild(li);
                    }
                    document.getElementById("message").append(erList);
                }else{
                    let successEl = document.createElement('p');
                    successEl.className = 'success';
                    successEl.textContent = res.msg;

                    var msgEl = document.getElementById("message");
                    msgEl.appendChild(successEl);
                    setTimeout(() =>{ 
                        document.getElementById("message").textContent = '';
                    }
                    , 3000);
                    var table = document.getElementById("list_table");
                        table.refresh ();
                    }
            });

        }
    } 


    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
            let erListExist = document.querySelector('.errorList');
            if(erListExist){
                erListExist.remove();
            }
        }
    }

    span.onclick = function () {
        modal.style.display = "none";
        let erListExist = document.querySelector('.errorList');
        if(erListExist){
            erListExist.remove();
        }
    }
</script>
<?php 
    require_once('views/layouts/footer.php');
?>