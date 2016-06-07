Dlayer
======

Warning
--------
Until the official v1.00 beta release the master branch can't be trusted, I will be pushing updates from my personal fork which will both break sections of the app and remove some of the current functionality. Up until this point (28th May 2016) master has always been stable(ish), after the the v1.00 release it will be again, for now though it is just easier for me to commit a cardinal sin.
  
Overview
--------

Dlayer is a responsive web development tool aimed primarily at users that don't have any web design or web development experience.

* Copyright: G3D Development Limited
* Original author: Dean Blackborough <dean@g3d-development.com>
* License https://github.com/Dlayer/dlayer/blob/master/LICENSE
* Contributions (Coding standards) http://www.dlayer.com/coding-standards.html

Requires
---------

* Bower (Installs Jquery and Bootstrap)
* SASS
* Zend framework 1.12 (Included) and MySQL

Documentation 
---------

Check http://www.dlayer.com/docs/ for the latest docs and a link to the current demo.

Setup
---------

* Set up development environment
* Clone project
* Setup database and import /private/database/release-database.sql
* browse to /public ```$ bower install```
* Edit /application/configs/application.ini
* Edit /application/configs/environment.php
* browse to /public ```$ sass --watch scss:css```
* Sign-in to demo
