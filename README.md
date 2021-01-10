# elastic-rabbit

## setup
    - have php, composer installed (Or use xamp)
    - clone this repository
    - cd into cloned folder
    - set your db credentials in config/db.php
    - import testyii.sql to your SQL server
    - run $composer install
    - check that "cookieValidationKey" is not empty  in config/web.php (IF YES set a random string)
    - run $ php yii serve
    - open localhost:8080 (admin/admin)
    - open classes/Rabbit.php and edit credentials
    - open classes/Search.php and edit base_url and index (index will be dynamic later)

### Hot to use
    Run development server by going into project directory and $ php yii serve .
    Then open the project main page "localhost:8080".
    Create some new records in rabbitmq queue to be indexed in elasticsearch server by clicking 
    "Create Object" and then filling the required fields(the model must be index name ex. user,post,product 
    and must be the the data that you want to be in that index {'name' : 'taha', 'age': 30}).
    By checking the queue server you must be able to see the data that is sent to 'azmon' queue.
    This is where the node app does its job and indexes the data to elastic server.
    now in search section you can specify a index and a search phrase.
    If you dont fill in a queue it will search all indexes. then this will return the data that is sent back.

### How it works

    There are 2 classes in app/classes directory, Rabbit and Search; Rabbit is responsible for sending created or updated article objects to "azmon" queue, so the node backend can index them to elastic server.
    Search class is responsible for sending new searchable entities to Rabbit class and also querying the elastic server for search in apps home page.

    when a new record is created, a http request is sent to ArticleController's create method (actionCreate), in this method we will instanciate Search class to send the created article to it.
    In Search class it will create an object suitable for being sent to Rabbit class (adaptor method), after making the object it will be sent with send method in Search class to Rabbit class and Rabbit class will submit it to Rabbitmq server.

    then in apps home page when you search for a phrase, it will be sent to ArticleController's search method, then in this method the phrase will be sent to CustomSearch model in models directory, in CustomSearch model's search method a new instance of Search will be created and the phrase will be sent to Search class's search method, this method will send an http request to elastic server and querys the phrase against the specified index (at top of the class), the results will be sent back to CustomSearch model and from there it will be sent back to ArticleController to be rendered in index view (home page of yii app).

    I know this is complicated but it was the best way that I could do it considering no prior knowledge of elastic, rabbit and yii.
    :)))) 


