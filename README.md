[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/Dlayer/dlayer/blob/master/LICENSE)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg)](https://php.net/)
[![Build Status](https://travis-ci.org/Dlayer/dlayer.svg?branch=master)](https://travis-ci.org/Dlayer/dlayer)

![Dlayer_Logo](public/images/favicon-192x192.png)

Dlayer
======

Thank you for taking the time to look at Dlayer, I've been working on this project for many years including the inevitable restarts, it has taken an inordinate amount of work to finally get here, now that I have a stable base I'm hoping to grow the project.

Over the next few weeks, I am going to continue to polish the core of the Content manager, work on the set-up process and then start reintegrating the removed designers, first on the list is the Form builder.

Latest stable release 
--------
v1.11 - Released 10th February 2017
 
Overview
--------

Dlayer is a responsive web development tool aimed primarily at users that don't have any web design or web development experience.

* Copyright: G3D Development Limited
* Author: Dean Blackborough <dean@g3d-development.com>
* License https://github.com/Dlayer/dlayer/blob/master/LICENSE
* Contribute?: If you would like to contribute to Dlayer, please review the coding standards at http://www.dlayer.com/coding-standards.html

Requirements
---------

* Bower (Installs Jquery and Bootstrap)
* SASS
* Zend Framework 1.12 (Included) 
* MySQL

Documentation 
---------

Please check the documentation at http://www.dlayer.com/docs/ the documentation is currently a little sparse, I am in the progress of moving it to http://dlayer.github.io/dlayer/

Setup
---------

I am working towards improving the set-up/reset process for Dlayer, until then please follow the steps below.

* Set-up your development environment. I have written a blog post on setting up a suitable environment on a Linux machine, http://www.deanblackborough.com/2016/04/30/ubuntu-install-apache-php-mysql-sass-bower-and-phpstorm-for-local-development/
* I will assume your local environment is at http://dlayer.dev
* Clone the project
* Create database and user
* Browse to /public and run ```$ bower install```
* Edit /application/configs/application.ini
* Edit /application/configs/environment.php
* Browse to /public and run ```$ sass --watch scss:css```
* Setup the database, go to http://dlayer.dev/setup to create/import database
* Sign-in to demo
