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

Start the laradock containers
> docker-compose up -d nginx mariadb workspace

Enter the container
> docker-compose exec --user=laradock workspace bash

#### Use yarn

To prevent warnings or errors in the deployment pipeline, please use yarn as frontend dependency manager.
