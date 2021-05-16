<?php 
    require_once('views/layouts/header.php');
?>
    <div class="container">
        <h1>Add Task</h1>
        <div class="message" id="message"></div>
        <form method="POST" onsubmit="addTask(event);" id="addTask">
            <label>Title</label>
            <input type="text" name="title" id="title">

            <label>Description</label>
            <input type="text" name="title" id="description"/>

            <input type="hidden" name="action" id="action" value="add_task"/>
            <div class='spinner'></div>
            <input type="submit" value="SUBMIT" class="button" id="submit_btn"/>
        </form>
    </div>  
<script>
    async function addTask(e){
        e.preventDefault();
        let erListExist = document.querySelector('.errorList');
        if(erListExist){
            erListExist.remove();
        }

        var submit_btn  = document.getElementById('submit_btn');
        submit_btn.style.display = 'none';

        var spinner = document.querySelector('.spinner');
        spinner.classList.add('loading');

        let title = document.getElementById('title').value;
        let desc = document.getElementById('description').value;
        let action = document.getElementById('action').value;
        
        
        const _url = 'Controllers/TodoList.php';
        let _body = {
            title: title,
            desc: desc,
            action: action
        };
        const _headers = {
        'Content-type': 'application/json; charset=UTF-8',
        };
        const _options = { method: 'POST', headers: _headers, body: JSON.stringify(_body) };
        await fetch(_url, _options).then((response) => {
            document.getElementById("addTask").reset();
            return response.json();
        }).then((res) => {
            spinner.classList.remove('loading');
            submit_btn.style.display = 'block';

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
            }
            // document.getElementById("message").textContent = res.msg;
        }).catch(error => alert(error.message));
    }
</script>
<?php 
    require_once('views/layouts/footer.php');
?>