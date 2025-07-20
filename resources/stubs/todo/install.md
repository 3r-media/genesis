# New Site ToDo List

### 3R Setup
- [x] Install Laravel (no starter kit sqlite unless MySQL is needed)
- [ ] change "minimum-stability": "dev"
````
laravel new testdomain
````
- [ ] herd secure testdomain
- [ ] git init
- [ ] create github repo
- [ ] add github remote
````
git remote add origin git@github.com:3r-media/testdomain.git
````
#### Edit composer.json
  - [ ] app name and description
  - [ ] APP_TIMEZONE='America/Chicago'
  - [ ] add 3R repository (for local or published packages)
```
"repositories": [
        {
            "type": "path",
            "url": "../3r-creator/packages/rrr/*"
        }
    ],
"repositories": [
        {
            "type": "composer",
            "url": "https://packages.3r.media"
        }
    ],
```
#### Genesis
- [ ] Install Genesis Package
````
composer require rrr/genesis 
php artisan genesis:install --force --dev-stack --robots
````
- [ ] Copy .env.example options to .env
- [ ] create testdomain database (if using mysql)
- [ ] php artisan migrate
- [ ] NPM Install & Run Build



### Git and Staging
- [ ] Github Repo
- [ ] Launch Staging Site
