# Installation

Installation instructions*:
 1. ~~Install [PHP 5.3+](http://php.net/downloads.php) if you've got 
    no global installation. This is required by PHP Composer. 
    In installation folder choose appropriate `php.ini-*` file to create
    `php.ini`. Check that extensions like `curl`, `openssl`, `mbstring` uncommented.
    Other extensions may be required by packages.~~ 
 1. ~~Install [Composer](https://getcomposer.org/) specifying global PHP installation 
    as it is required for proper Composer performance.~~
 1. `git clone ` _`this-repo-url`_ _`web-server-document-root`_
 1. ~~Install [PHP Wrapper for Pokemon API](https://github.com/danrovito/pokephp) for [RESTful pokeapi.co](http://pokeapi.co/) 
    into~~
 1. Install SSL certificate for proper cURL operation under `localhost` on development stage:
    * [download this certificate](https://curl.haxx.se/ca/cacert.pem)
    * add `curl.cainfo = "path_to_cert\cacert.pem"` to `php.ini` under
      your web-server
 1. Check `php.ini` on your web-server has timezone set: e.g. `date.timezone = Europe/Kiev`
 1. ~~Tune-up `httpd.conf` (see below)~~
 1. You may want to set-up virtual host for development purposes (see below)
 1. Create `pokedata` database
    * Use `root`/`usbw` credentials to access MySQL.
    * Please, change these via DB admin panel and in `app/config.db.php`.
    * Create database `pokedata` with collation `utf8mb4_unicode_520_ci` (choose different,
      language specific collation should your textual content be in a single
      language and relevant collation provided by DB engine)
    * Import data from `_bup` if any.
 1. Use `dist` branch to publish app on web-site. See `webhook.git.php`
    for details.
 
*) Striked-out instructions stay for retrospection reasons. These aren't 
required to set-up the project anymore.
 
 

## Server Request URI Rewrite Rules

**NB!** Based on **USB Webserver** configuration.

In `settings/httpd.conf` check that `mod_rewrite` is allowed.

Rewrite rules are described in root `.htaccess`.

## Virtual Host

Facebook Graph API doesn't allow registering applications
on top-level domains. So, `localhost` doesn't fit the rule.

**1. Provide virtual host resolution on OS level**

Under Windows: add line `127.0.0.1 pokemondo.loc` 
to `%WINDIR%\System32\drivers\etc\hosts`
  
**2. Declare virtual host in web-server config**

Add following section at the end of `settings/httpd.conf`

```
<VirtualHost localhost:{port}>
    ServerAdmin webmaster@pokemondo.loc
    DocumentRoot "{rootdir}"
    ServerName pokemondo.loc
    ErrorLog "logs/pokemondo.loc-error.log"
    CustomLog "logs/pokemondo.loc-access.log" common
</VirtualHost>
```

Relaunch web-server for the changes to take effect. 

**Result**

Now your web-site is accessible locally 
at [pokemondo.loc:8080](http://pokemondo.loc:8080/).
