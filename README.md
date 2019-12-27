# whitelabel-module

## Project Setup 

### Docker
In the laradock folder
> cd laradock

Copy the env File
> cp env-example .env  

Change the DATA_PATH_HOST variable inside the laradock .env

># Choose storage path on your machine. For all storage systems
>DATA_PATH_HOST=~/.laradock/data

Remove the **Cassandra** and **Gearman** Definitions in the laradock 
they seemed to be faulty configured and we don't use them.

Start the laradock containers (run inside the laradock folder)
> docker-compose up -d nginx mariadb workspace

To stop the containers run
> docker-compose down

Enter the container
> docker-compose exec --user=laradock workspace bash
