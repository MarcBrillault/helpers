# My personal helpers

These are some of the functions I use intensively for my projects.

# cliHelpers

These helpers are made specifically for command-line interfaces (CLI)

## cliSpinner

Adds a nice spinner to your loops.

```php
foreach($myvar as $var) {
    cliSpinner('Manipulating data');
    // Do something
}
cliSpinner('Done !', true);

```

## getCliArguments

Just add `$args = getCliArguments();` at the beginning of your CLI script, and use your CLI script as you do with a bash
script.

```
php myScript.php -action makeSomething -verbose
```

The array `$args` will now contain :
- action: 'makeSomething'
- verbose: true

You can also give an array of allowed arguments in the first parameter of `getCliArguments()`. Any parameter other than
the ones listed will generate and error and die.
