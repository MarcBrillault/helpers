# My personal helpers

These are some of the functions I use intensively for my projects.

# cliHelpers
These helpers are made specifically for command-line interfaces (CLI)

## getCliArguments
This method allows to pass the arguments as you'll do in a normal bash script, in any order.

Simply call `$args = getCliArguments()` at the beginning of your script, and call it with the arguments you want, like so :

```
php myscript.php -arg1 myFirstArg -arg2 "My second argument" --test
```

`$args` is now an array containing :
- arg1: 'myFirstArg'
- arg2: 'My second argument'
- arg3: true

It is also possible to limit the available arguments, by setting them as the first argument of `getCliArguments()`:

```php
$availableArgs = [
    'v',
    'p',
];
// or
$availableArgs = [
    'v' => 'verbose',
    'p' => 'productId',
];

$args = getCliArguments($availableArgs);

```

Now, if any of the CLI parameters is not in the given list (`v` or `p`, the second version also accepts `verbose` and `productId`), the script dies with an error message.

```
php myscript.php -p 159 -v
```

As for the `$args` value, with the previous call, the corresponding values will be the following :
- p: 159
- v: true

and

- productId: 159
- verbose: true