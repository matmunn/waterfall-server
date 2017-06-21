#### Cloning

You can clone the project from git in the usual way.

Then run `yarn` to pull in all the required dev packages. Once you meet the criteria set up in the Environment section you'll be able to run `yarn watch` to compile all the JavaScript.

#### Environment

Waterfall now relies on a [Slanger](https://github.com/stevegraham/slanger) installation to push notifications to all users, this replaced the temporary measure of refreshing all data every 15 seconds.

By default `redis-server` should start on the VM automatically, however if for some reason the VM goes down then Slanger will need to be restarted manually:
```
slanger --app_key waterfall --secret waterfall &
```
The ampersand will force slanger to run in the background.

The dev server runs on `http://waterfall.dev`

#### Updating

I've been building on a `build` branch so that `master` doesn't get polluted.

When switching to master and merging your changes you'll also need to run `yarn production production` to tree shake and minify all your code.

#### Deploying

When deploying your updated code to the VM the best way to do it is to put Laravel into maintenance mode:
```
php artisan down
```

Once in maintenance mode you can pull the new codebase using git. Make sure you don't forget to run any new migrations or pull in new composer packages.


Once your update is complete you can do the following:
```
php artisan up
php artisan waterfall:update-available
```

This will bring Laravel out of maintenance mode and push a notification to all users asking them to refresh their copy of Waterfall.

#### Misc

The VM currently has a statically assigned IP address of `192.168.1.73`. The Windows Server pushes out a DNS route for `waterfall.app` but it hasn't seemed to stick across the network, so each computer has a hosts entry.

Windows: `C:\Windows\System32\drivers\etc\hosts`
Linux/Mac: `/etc/hosts`
