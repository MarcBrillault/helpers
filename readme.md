# My personal helpers

These are some of the functions I use intensively for my projects.

# cliHelpers
These helpers are made specifically for command-line interfaces (CLI)

## getCliArguments
This method allows to pass the arguments as you'll do in a normal bash script, in any order.

Simply call `$args = getCliArguments()` at the beginning of your script, and call it with the arguments you want, like so :

```
php myscript.php -arg1 myFirstArg -arg2 "My second argument" -test
```

`$args` is now an array containing :
- arg1: 'myFirstArg'
- arg2: 'My second argument'
- arg3: true

It is also possible to limit the available arguments, by setting them as the first argument of `getCliArguments()`:

```php
$availableArgs = [
    'verbose',
    'productId',
];

$args = getCliArguments($availableArgs);

```

Now, if any of the CLI parameters is not in the given list, the script dies with an error message.

```
php myscript.php -productId 159 -verbose -unallowedParameter
```

As `unallowedParameter` is not whitelisted, the script dies and explains the available arguments.

```
Argument not allowed : unallowedParameter
Allowed params are :
        -productId
        -verbose
```