# Iconly test project back-end
This project is the response of the given test task

## What you should do in order to run the code
This project is created using *Laravel sail*. So, all you need to run the project
is to have `docker` and `docker compose` packages. If you have both, simply run
`./vendor/bin/sail up` and the project will be served at `127.0.0.1:80`.
If you want to serve the code at some other ports, simply change the `APP_PORT`
environment variable value.  
Note: If you change the `APP_PORT` value, you need to tell the front-end project
to which port should it send requests. Check out the front-end project's README
file in order to check how to do it.

Run the following commands for sail:

```shell
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed IconSeeder
./vendor/bin/sail artisan storage:link
```

Or if you directly served the project wth php:

```shell
php artisan migrate
php artisan db:seed IconSeeder
php artisan storage:link
```

## What I did
This project has two simple controllers; One for Auth logic and second is for
icons' fetch and download. I have also implemented a new model and migration for
icons and added PNG files of the icons to the project's storage.

### Stateful authentication
Laravel comes with many authentication logics. I chose a stateful one. For low
traffic websites, stateful authentication is a good method since users retrieve
their profile data everytime. So, If someone changes his name in his mobile
device, the name will be updated without re-login in his desktop device.  
But for crowded websites with high range of concurrency, stateless authentications
such as JWT is better approach as every authentication process, needs a query to
the database in stateful authentications. Since this project is for testing
purposes, I decided to pick Laravel default authentication logic which is stateful.

### Committed files from storage directory
It's usually not a good practice to push storage files to the git repository.
I did it for minimizing configuration for running the project.

### Hash named icons
If you check the name of the icons, You see that they are all hashed. That's
because If a malicious user finds the list of the icons' names and the icons' path,
he can access to all icons by their name. When names are hashed, No one can guess
the filename from the original filename!

#### Downloaded Icons name is the original name
Icons' original filename is stored in database. So when user downloads some icons,
he / she gets the ZIP file with original and human-readable file names.

### Stream download VS direct download
Streaming large files needs lots of memories.
