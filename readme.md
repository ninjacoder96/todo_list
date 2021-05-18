# <h1>TODO LIST</h1>
TODO LIST CRUD 

<h2> Intallation </h2>
<ul>
<li>Clone the project <code>git clone https://github.com/ninjacoder96/todo_list_oop.git</code></li>
<li>run the command <code>composer install</code>, this will install twig template.</li>
<li>On the Db/migration folder, copy the <code>todo_list.sql</code> and run it to any MySQL GUI </li>
<li>Under Db, open the Config.php and edit the database config based on your config. You can test the adapter by changing the <Code>Pdo</Code> to <code>Mysqli</code></li>
</ul>

<h2>Languages</h2>
Twig 3.^<br/>
php ^7.3<br/>

<h2>Features</h2>
CRUD List (CRUD in Progress)<br/>
Advance Pagination<br/>
Fetch API 


<h2>Structure</h2>
<p>The Project Structure are mixed with Adapter for DB Drivers and Factory for handling Records.
The <code>Mysql.php</code> and <code>Pdo.php</code> are factories that implements DB Adapter for the freedom of using different drivers.
</p>

<p>
The <code>AdapterInterface.php</code> contains the abstract functions that should follow when using different drivers. 
</p>









