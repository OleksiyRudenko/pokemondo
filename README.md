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
 1. Create `pokedata` database
    * Use `root`/`usbw` credentials to access MySQL.
    * Please, change these via DB admin panel and in `app/config.db.php`.
    * Create database `pokedata` with collation `utf8mb4_unicode_520_ci` (choose different,
      language specific collation should your textual content be in a single
      language and relevant collation provided by DB engine)
 
*) Striked-out instructions stay for retrospection reasons. These aren't 
required to set-up the project anymore.
 
 
## `httpd.conf`
 
 NB! Ignore this section. Tuning replaced with `.htaccess` rules.
 
 Check that `mod_rewrite` is allowed. 
 
 Add as a last section:
 ```
 <IfModule rewrite_module>
     RewriteEngine on
     RewriteCond %{SCRIPT_FILENAME} !^/(css/|img/|js/|phpmyadmin) [NC]
     RewriteRule ^(.+)$ /index.php/$1 [L]
 </IfModule>
 ```
 