# OpenPlatform client lib.

[![codecov](https://codecov.io/gh/reload/openplatform-client/branch/master/graph/badge.svg)](https://codecov.io/gh/reload/openplatform-client)

This package provides a simple interface to
[OpenPlatform](https://openplatform.dbc.dk/v3/) provided by DBC.

## Installation

```shell
composer require danskernesdigitalebibliotek/openplatform
```

## Usage

A working example:

``` php
$op = new OpenPlatform($token);

$req = $op->searchRequest();
$req->setQuery('harry AND potter');
$req->setFields(['pid', 'title']);

$res = $req->execute();

foreach ($res->getData() as $material) {
    print $material['pid'][0] . ': ' . $material['title'][0] . "\n";
}
```

In short:

1. Create an OpenPlatform instance and supply it a token (see [How to
   obtain a token](#how-to-obtain-a-token)).
2. Call a `*Request` method to get a request instance.
3. Request parameters are supplied with setters.
4. Call execute to get a lazy loading result.
5. Get response data from getters on the response object.

### Generic requests

As this library is far from complete in regard to the amount of calls
implemented, there's also a generic request that'll work with any
OpenPlatform call that: a) takes an access token and b) has statusCode
in the reply (which should be all of them).

### Lazy loading

This library uses [Symfony
HttpClient](https://symfony.com/doc/current/components/http_client.html),
so responses only perform the request when you ask for the data. Also
means that you can create multiple responses, and the requests will be
performed in parallel when accessing data on any one.

## CLI command

The library includes a CLI command, `bin/openplatform`, which
functions both as a practical example, and as an exploratory tool. You
need to install dev dependence for the project in order to use it.

## How to obtain a token

You can get a token keyed to a user by authenticating the user with
[Adgangsplatformen](https://github.com/DBCDK/hejmdal). You can use
[oauth2-adgangsplatformen](https://github.com/reload/oauth2-adgangsplatformen)
for communicating with the service.

If you have a client id and secret, you can generate a token at
https://openplatform.dbc.dk/v3/ .
