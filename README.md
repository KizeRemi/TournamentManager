<h1>Colab REST API</h1>
<hr/>
Colab restful api...


<h2>Getting Started</h2>

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

<h3>Prerequisities</h3>

To install the project, you need to have on your computer : 

<li> Composer </li>

<h3>Installing</h3>

Open a terminal on your computer, go to the installation folder, and clone the repo. 

Go to the repo and type the command bellow to create a SSH Key

```
$ cd PROJECT_DIR
$ mkdir -p var/jwt
$ openssl genrsa -out var/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem`

```

`$ composer update`

Complete the asked informations.

<h3>Generating Documentation</h3>

First, you have to install [PHPDocumentor](https://phpdoc.org/docs/latest/getting-started/installing.html). 

Next, go to project folder and type that : 

`$ phpdoc -d ./src -t ./docs`

With your favorite browser, go to [http://127.0.0.1/docs](http://127.0.0.1/docs) to read the doc. 

<h2>Authors</h2>

<li>Laouiti Elias Cédric [Github](https://github.com/morpheus93)
<li>Mavilaz Rémi [Github](https://github.com/KizeRemi)