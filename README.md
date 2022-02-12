## Developed in:
[Laravel](https://laravel.com/docs/9.x) (9)

## Requirements:
1. [PHP](https://www.php.net/) (8)
2. [MySQL](https://www.mysql.com) (8)
3. [Composer](https://getcomposer.org/) (2.1)

### Instructions for installing the project:

this project is dockerized, to start the project you just need run the comand with docker:

```sh
docker-compose up
```

this challenge was developed in TDD, so if you like to see all the tests you can run:

```bash
docker-compose exec desafio-strider_app_1 bash -c "php artisan test"
```
### Documents

![class-document](https://user-images.githubusercontent.com/31326015/153693644-ba663651-4bcb-4bbd-bfb2-2a8a7901c4ca.png)

#### api-docs

I tried use swagger but how i change the usual structure i had some problems.

Please, install insomina and import thease file inside folder docs, named insomnia.json

# notes

By default, Laravel implements the MVC architecture. I implemented the max that I the solid principles with DDD architecture, using actions, repositories, and dependency injection.

------
## Planning

Well, for this feature I suggest using a specific tag (defined by the PO) to identify the mentioned users.

My idea is created the tag like {User}any_username{/User}. (This tag can be converted from front-end to back-end using the @.)
And when the user request to create a post, we analyze if the content has the regex. If the regex exists, and the user it`s valid/exists we create the reply to post

------
## self-critique
If I had more time, probably implement graphql because,   a lot of features, routes, and optional parameters will come. GraphQL will reduce the payload and we can design a lot of schemas that will help us.

talking about infrastructure I would implement all the environments in containers using docker with AWS using load balance to manage all the load of the containers. If we have a lot of access we just build a new machine with the project in docker.
