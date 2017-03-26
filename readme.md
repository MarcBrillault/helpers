# My personal helpers

These are some of the functions I use intensively for my projects.

As I don't want my functions to interfere with any of yours, they all use the `Brio` namespace.

# cliHelpers

These helpers are made specifically for command-line interfaces (CLI)

## cliArguments

Just add `$args = Brio\cliArguments();` at the beginning of your CLI script, and use your CLI script as you do with a bash
script.

```
php myScript.php -action makeSomething -verbose
```

The array `$args` will now contain :
- action: 'makeSomething'
- verbose: true

You can also give an array of allowed arguments in the first parameter of `cliArguments()`. Any parameter other than
the ones listed will generate and error and die.

## cliProgressBar

Displays a nice progressBar.

Since the display is updated less frequently than the spinner, it is slightly quickier than `cliSpinner`.

```php
foreach($myvar as $var) {
    Brio\cliProgressBar($currentIndex, $total);
}
```

## cliSpinner

Adds a nice spinner to your loops.

```php
foreach($myvar as $var) {
    Brio\cliSpinner('Manipulating data');
    // Do something
}
Brio\cliSpinner('Done !', true);

```

## cliTable

Displays an array as a readable table.

By default, the first value's keys will be used as header names.

```php
$table = [
    [
        'id'    => 1,
        'name'  => 'John Doe',
        'email' => 'john@doe.com',
    ],
    [
        'id'    => 2,
        'name'  => 'Jane Doe',
        'email' => 'jane@doe.com',
    ],
];

echo Brio\cliTable($table);
```
will be displayed like this :
```
╔════╤══════════╤══════════════╗
║ id │ name     │ email        ║
╟────┼──────────┼──────────────╢
║  1 │ John Doe │ john@doe.com ║
║  2 │ Jane Doe │ jane@doe.com ║
╚════╧══════════╧══════════════╝
```

# strHelpers

## strCut

Cuts a text at a given number of characters.

If `$isTotalLength` is set to `true`, the final maximum length will be `$length`. If it set to false, the final maximum
length will be `$length + strlen($end)`.
