
    <div class="container">
        <h1>Generate Random Data</h1>
        <form method="POST" onsubmit="generateData(event);">
            <label>Number of Data</label>
            <input type="text" name="no_of_data" id="no_of_data"/>

            <input type="hidden" name="action" id="action" value="generate_data"/>
            <input type="submit" value="SUBMIT" class="button"/>
        </form>
    </div>  
<script>
    function generateData(e){

        e.preventDefault();
        let data = document.getElementById('no_of_data').value;
        let action = document.getElementById('action').value;

        
        
        const _url = 'Controllers/DataGenerator.php';
        let _body = {
            data: data,
            action: action
        };
        const _headers = {
        'Content-type': 'application/json; charset=UTF-8',
        };
        const _options = { method: 'POST', headers: _headers, body: JSON.stringify(_body) };
        const response = fetch(_url, _options);
        if (response.status >= 200 && response.status <= 204) {
            let data =  response.json();
            console.log(data);
        } else {
         console.log(response.error);
        }
    }
</script>
