## Set up
### Ensure you have the following items in your `.env`
```sh
GITHUB_TOKEN=
GITHUB_ORG=
GITHUB_PROJECT= 
```
The `GITHUB_PROJECT` needs to be the integer that GitHub numbers your project.


Ensure that your Github Token has the right permissions to view your projects, issues and PRs

Run:
```sh
php artisan migrate
```
Set up your database if need be. 

Create yourself a default user account: 
```sh
php artisan make:default-user
```

Default user is: admin@admin.com 
Password: admin

Then login and see the magic... 
