# whitelabel-module

## Setup 

#### Clone the Project
```sh
$ git clone git@git.desiretec.com:desiretec/whitelabel-module.git
```
#### Setup docker aliases (optional)
Create some aliases for easier day-to-day usage. 
You can add those aliases to your `.bashrc` file in order load them automatically on start of your bash shell (if u use zsh this file is called `.zshrc` and so on).

```sh
# General docker aliases

# starts containers in daemon mode (background) 
# example: 
#   dcup mariadb nginx workspace
#   This will start mariadb, nginx and the workspace container of Laradock
alias dcup="docker-compose up -d"
# shutdown containers
alias dcdn="docker-compose down"
# Access logs of current docker-compose stack.
# Keep in mind that u have to head over into the laradock folder in order to see the logs of the laradock containers!
alias dclf="docker-compose logs -f"


# Laradock specific aliases

# Runs artisan inside the workspace container of laradock!
# Run this command inside the project dir, not inside the laradock folder!
# examples: 
#   dartisan cache:clear
#   dartisan migrate --fresh
alias dartisan="docker-compose -f laradock/docker-compose.yml exec workspace php artisan"

# This alias mounts the current directory into temporary container running the latest composer.
# Run this command inside the project dir, not laradock!
# examples: 
#   dcomposer install 
#   dcomposer install --no-dev
#   dcomposer update
alias dcomposer='docker run --rm --interactive --tty \
    --volume "$PWD":/app \
    composer:latest'
```

### Laradock setup
Switch to the laradock folder
```sh
$ cd laradock
```

Copy over the `env-example` to `.env`.
```sh
$ cp env-example .env  
```

#### This step is important to avoid data loss!

Change the `DATA_PATH_HOST` variable inside the laradock `.env` file and dont let it point towards your home directory.
If you are working with multiple laradock setups locally it would overwrite the laradock data in your home directory.

```dotenv
# this will 
DATA_PATH_HOST=.laradock/data
```

#### Initialize project

1. Install composer packages. `dcomposer install` or `composer install`
2. Install node packages. `yarn install`
3. Start webpack-dev-server for hot reload of frontend assets. `yarn run hot` or `npm run hot`. As alternative u can use `npm run watch` in order to work with a filewatcher instead of the webpack-dev-server 
4. Start laradock. Run `dcup nginx mariadb workspace` or `docker-compose up -d nginx mariadb workspace` inside the laradock folder.


#### General Usage
Start the laradock containers needed for this project (run inside the laradock folder)
```sh
$ docker-compose up -d nginx mariadb workspace
# You can also run if u have setup the aliases
$ dcup nginx mariadb workspace
```
To stop the containers run
```sh
$ docker-compose down 
# If u have the aliases installed
$ dcdn
```
To open a shell inside a container
```sh
$ docker-compose exec workspace bash
# usage: docker-compose exec SERVICE COMMAND_TO_EXECUTE 
# You will find the name of the SERVICE inside the docker-compose.yml of laradock!
```
