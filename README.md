<br/>
<p align="center">
  <a href="https://github.com/amirreza77/PHP-SWOOLE-MicroFrameWork">
    <img src="images/logo.png" alt="Logo" width="80" height="80">
  </a>

  <h3 align="center">PHP SWOOLE Microframework</h3>

 
</p>
 
## Table Of Contents

* [About the Project](#about-the-project)
* [Built With](#built-with)
* [Getting Started](#getting-started)
  * [Installation](#installation)
* [Usage](#usage)
* [Authors](#authors)

## About The Project

![Screen Shot](images/screenshot.png)

This project is designed for use in microservices. It has been designed in a way that, based on your API, you can have a fully-featured, lightweight, and high-speed PHP Swoole microservice up and running with just a few installation and configuration options.
First and foremost, let me clarify that this project is exclusively designed for API usage and does not include a backend or frontend. However, it serves as a powerful engine for creating CRUL requests based on PHP Swoole. The prerequisites for using this system are as follows:

* PHP 8.1
* PHP SWOOLE Extension
* Composer
* Linux 



## Built With

For the sake of easy usability, quick responsiveness, and effortless installation and setup, this project utilizes certain libraries, which I will mention below:

* [phpdotenv](https://github.com/vlucas/phpdotenv)
* [Carbon](https://carbon.nesbot.com/)
* [Medoo](https://github.com/catfan/Medoo)
* [FastRoute](https://github.com/nikic/FastRoute)

## Getting Started

To get started, simply download the project files and then extract them. Inside your desired folder, first execute the command:
 
```sh
composer update
```
This will install all the libraries in the "vendor" directory.

### Installation

I can almost tell you that everything is ready, but before anything else, I prefer we dive into the system settings. This is because you need to connect to the database or configure the desired port for your microservice. All configurations are located in the ".env" file, which I will explain to you in order when you open this file. You will be faced with the following options:

```sh
MACRO_NAME=yourMacroName
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=yourDataBaseName
DB_USERNAME=yourDataBaseUserName (Usually root)
DB_PASSWORD=yourDataBasePassword
DB_PREFIX=
SWOOLEHOST=0.0.0.0
SWOOLEHOSTNAME=127.0.0.1
SWOOLEPORT=SWOOLE-PORT (IT SHOULD BE A NUMBER, Ex. 8020)
```
First, create your database and enter its details in the ".env" file. Don't forget that for the "SWOOLEPORT" option in the last line, you only need to enter the port on which you want your application to run.

## Usage

Using this project is very easy. To better understand it, let me explain a bit about its architecture first. Throughout all stages, I always strive to maintain system simplicity because you may want to use a sub-service for a larger project and wish to train your team on it. Overcomplicating a project can make your work much more challenging. Now, let's take a closer look at the directories in this system.
 ###### Directory: app\Models
All your models reside in this directory. You can create a model for each of your routes. For example, I have a route that is called using a simple GET request:
```sh
http://yourdomain.com/exampleroute
```
If you open this directory, you will notice that I've created a model with the same name. Although the model name is optional, I believe it makes things more understandable. In the file **exampleModel.php**, I've created a class that can contain various functions. For instance, I've created a function named **exampleFunction**. This function connects to the database using an ORM called **Medoo** and returns a response. But the question here is, how does the system know that for our example route:
```sh
http://yourdomain.com/exampleroute
```
The answer is simple. Everything comes back to the **api.php** file located in the **router** directory. To better understand, let's first allow me to examine this file.
First, at the topmost section of this file, I've included the *exampleFunction* model. Then, for *FastRoute* routing, I've added the necessary PHP-Swoole classes at the end. I've also added two functions named *exampleRoute* and *get_start*. The second function, *get_start*, is generally not required but can be quite useful. You will understand why it can be handy later on. To understand what these two functions do, go to line *58*; this is where the routes are defined.
```sh
    $r->addRoute('POST', '/', 'get_start');
    $r->addRoute('GET', '/', 'get_start');
    $r->addRoute('POST', '/exampleroute', 'exampleRoute');
    $r->addRoute('GET', '/exampleroute', 'exampleRoute');
```
The URL address 
```sh
http://yourdomain.com/exampleroute
```
will call *exampleRoute* and this function Call *exampleFunction* in the *exampleModel* that is it ! 
  ##### Additional Acknowledge
In the simplest possible terms, I've tried to explain how the system works to you, but here are some additional points that might be useful for your projects:

 * You can utilize validation within the function called when the class is invoked, such as in our example, **exampleRoute**.
 * You can add various libraries, like Symfony components or even Redis, which I always use for my projects.
 * If you have a bit more knowledge about PHP-Swoole, you can configure server settings in the *STORAGE* directory.
 * If you want to restrict responses to specific *IP addresses*, you can do so in the *api.php* file at line **121**. However, personally, I handle this at the gateway level using *KONG API GATEWAY* or Kubernetes since I always use them. 

  ### **How To RUN Your Project**
To run your project, you can use the **nohup** command as follows, which will keep your project running in the background:
```sh
nohup php index.php &
```
## Authors

* **AmirReza Tehrani** - *PHP Developer* - [AmirReza Tehrani](https://github.com/amirreza77) - **
 
