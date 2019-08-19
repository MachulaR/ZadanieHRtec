Index
------------


- [Installation](#installation)
- [Usage](#usage)
- [Testing](#testing)



Installation
------------

Use command line

``` bash
$ composer require "machular/rekrutacjahrtec": "1.0"
```
Or just download zip file.

Usage
-----

``` bash
use one of two commands.
$ php src/console.php csv:simple URL PATH"
$ php src/console.php csv:extended URL PATH"
```

```
URL has to start with http or https.
PATH is  directory where to save a file. Remember to include file name (with proper extension) as well!

```

Testing
-------

``` bash
$ phpunit
```
