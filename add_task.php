<?php 
    require_once('views/layouts/header.php');
?>
    <div class="container">
        <h1>Add Task</h1>
        <form method="POST" onsubmit="addTask(event);">
            <label>Title</label>
            <input type="text" name="title" id="title">

            <label>Description</label>
            <input type="text" name="title" id="description"/>

            <input type="hidden" name="action" id="action" value="add_task"/>
            <input type="submit" value="SUBMIT" class="button"/>
        </form>
    </div>  
<script>
    function addTask(e){

        
        e.preventDefault();
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
        'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8',
        };
        const _options = { method: 'POST', headers: _headers, body: JSON.stringify(_body) };
        const response = fetch(_url, _options);
        if (response.status >= 200 && response.status <= 204) {
            let data =  response.json();
            console.log(data);
        } else {
         console.log(`something wrong, the server code: ${response.status}`);
        }
    }
</script>
<?php 
    require_once('views/layouts/footer.php');
?>