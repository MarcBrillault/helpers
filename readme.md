# My personal helpers

These are some of the functions I use intensively for my projects.

As I don't want my functions to interfere with any of yours, they all use the `Brio` namespace.

# Command Line Interface (CLI) helpers

These helpers are made specifically for command-line interfaces (CLI)

## cliArguments

Just add `$args = Embryo\cliArguments();` at the beginning of your CLI script, and use your CLI script as you do with a bash
script.

```
php myScript.php -action makeSomething -verbose
```

The array `$args` will now contain :
- action: 'makeSomething'
- verbose: true

You can also give an array of allowed arguments in the first parameter of `cliArguments()`. Any parameter other than
the ones listed will generate and error and die.

## cliIsInterface

Tells whether the current script is called in a command-line interface.

## cliProgressBar

Displays a nice progressBar.

Since the display is updated less frequently than the spinner, it is slightly quickier than `cliSpinner`.

```php
foreach($myvar as $var) {
    Embryo\cliProgressBar($currentIndex, $total);
}
```

## cliPrompt
Prompts a question to the user, and returns a boolean: `true` if the answer is the first letter or the first answer,
`false` in every other case.

If no answers are set, default answers are `[y]es / [n]o` 

```php
Embryo\cliPrompt('Do you want to continue ?');
```
Will display `Do you want to continue ? [y]es / [n]o`, and will return true if the answer is either `y` or `yes`.


```php
Embryo\cliPrompt('Do you want to continue ?', ['continue', 'abort']);
```
Will display `Do you want to continue ? [c]ontinue / [a]bort`, and will return true if the answer is either `c` or 
`continue`.

## cliQuestion

Displays a question to the user, and returns his answer as a string.

```php
$answer = Embryo\cliQuestion('What is the airspeed velocity of an unladen swallow ?');
```

## cliSpinner

Adds a nice spinner to your loops.

```php
foreach($myvar as $var) {
    Embryo\cliSpinner('Manipulating data');
    // Do something
}
Embryo\cliSpinner('Done !', true);

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

echo Embryo\cliTable($table);
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

# Debug helpers

## d

Dumps a variable. The second parameters allows to dump only if the corresponding $_REQUEST ($_GET or $_POST) parameter
exists, and is equivalent to true.

```php
\Embryo\d($myVar);
```

## dd

Like `\Embryo\d()`, this function dumps a variable. It also dies just after.
 
If nothing has been to the browser before the call, and the data is an array or an object, a json header will be sent
and the data will be displayed as a json string.


## pp

Pretty prints a given value by wrapping a var_dump into `<pre>` tags

# SEO helpers

## seoUrl
Creates an URL from any UTF-8 compatible given string.

It removes the accents, and replaces all non-alphanumeric character by hyphens.

```php
$url = \Embryo\seoUrl("I'm giving my résumé to the café, Señor !");
// $url equals 'i-m-giving-my-resume-to-the-cafe-senor'
```

## unparseUrl
This method is intended to be a reverse of PHP's builtin [parse_url](http://php.net/manual/en/function.parse-url.php).
The parsed url's `query` key can be a string or an array.

# string helpers

## strComplete

Completes a string to a given length. If the length is shorter than the string, it will return the full, non-altered string.

```php
$str = \Embryo\strComplete('test', 10, ' ');
// $str is 'test      '
```

## strCut

Cuts a text at a given number of characters.

If `$isTotalLength` is set to `true`, the final maximum length will be `$length`. If it set to false, the final maximum
length will be `$length + strlen($end)`.

If $length is >= 40, the function will not cut into a word, but just after the previous word.

## strIsFourByteUtf8

Tells whether a string contains four-byte UTF-8 characters

## strIsJson

Tells whether a given string is valid JSON

## strIsUtf8

Tells whether a given string is encoded in UTF-8.

## strIsXml

Returns whether the given string contains valid XML code (including HTML)

## strRemoveFourByteUtf8Characters

Replaces all four-bytes UTF-8 characters into a given UTF-8 string.

It can be used to prevent `Illegal mix of collation` errors in your database queries, for example.
