# elastic-rabbit

## setup
    - have php, composer installed (Or use xamp)
    - clone this repository
    - cd into cloned folder
    - create a database name : 'testyii'
    - import testyii.sql to your SQL server (http://localhost/phpmyadmin/)
    - run $composer install
    - create .env file and copy the contents of .env.example in it
    - fill the data needed in .env file
    - run $ php yii serve
    - open localhost:8080 (admin/admin)

### Hot to use
    Login with credentials 
    got to posts (http://localhost:8080/posts/index)
    create a new post or update an existing one
    by checking your elastic server you can see that the title of the post is added as a doc


### How it works

    There are 2 classes in app/classes directory, Rabbit and Search; Rabbit is responsible for sending created or updated article objects to "azmon" queue, so the node backend can index them to elastic server.
    Search class is responsible for sending new searchable entities to Rabbit class and also querying the elastic server for search in apps home page.

    when a new record is created, a http request is sent to ArticleController's create method (actionCreate), in this method we will instanciate Search class to send the created article to it.
    In Search class it will create an object suitable for being sent to Rabbit class (adaptor method), after making the object it will be sent with send method in Search class to Rabbit class and Rabbit class will submit it to Rabbitmq server.

    then in apps home page when you search for a phrase, it will be sent to ArticleController's search method, then in this method the phrase will be sent to CustomSearch model in models directory, in CustomSearch model's search method a new instance of Search will be created and the phrase will be sent to Search class's search method, this method will send an http request to elastic server and querys the phrase against the specified index (at top of the class), the results will be sent back to CustomSearch model and from there it will be sent back to ArticleController to be rendered in index view (home page of yii app).

    I know this is complicated but it was the best way that I could do it considering no prior knowledge of elastic, rabbit and yii.
    :)))) 


