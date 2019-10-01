# OpenPlatform client lib.

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
$req->query = 'harry AND potter';
$req->fields = ['pid', 'title'];

$res = $req->execute();

foreach ($res->data as $material) {
    print $material['pid'][0] . ': ' . $material['title'][0] . "\n";
}
```

In short:

1. Create an OpenPlatform instance and supply it a token.
2. Call a `*Request` method to get a request instance.
3. Request parameters are supplied as properties on the request object
   and are documented with `@property`, so your IDE should provide
   useful completion.
4. Call execute to get a lazy loading result.
5. Access response data as properties, or use any helper methods the
   Response classes provide.

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
