Index
------------


- [Installation](#installation)
- [Usage](#usage)
- [Testing](#testing)



Installation
------------

Use command line

Add to your composer.json file.
``` bash
{
  "repositories": [
    {
      "type": "package",
      "package": {
        "name": "machular/zadaniehrtec",
        "version": "1.0",
        "source": {
          "url": "https://github.com/MachulaR/ZadanieHRtec",
          "type": "git",
          "reference": "master"
        }
      }
    }
  ],
  "require": {
    "machular/zadaniehrtec": "1.0"
  }
}

```
then via command line
``` bash
$ composer require "machular/zadaniehrtec":"1.0"
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
