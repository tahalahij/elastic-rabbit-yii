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

### Hot to use
    Login with credentials 
    got to posts (http://localhost:8080/posts/index)
    create a new post or update an existing one
    by checking your elastic server you can see that the title of the post is added as a doc
