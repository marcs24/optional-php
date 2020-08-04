### Description
Do you annoyed to check if an index or an attribute of an object or array exist like this?
```php 
if(isset($exampleArray['index']) && isset($exampleArray['index']['anotherIndex'])) {
 // do something with anotherIndex
}
```
or like this
```php 
if(isset($exampleObject->attribute) && isset($exampleObject->attribute->attribute2)) {
 // do something with attribute2
}
``` 
this package will help you to avoid this ugly conditions, no other packages needed!

### Usage
simply do:
```php 
$example = [
    'exampleIndex' => [
        'exampleIndex1' => 'hello world'
    ]
]
Optional::of($example)['exampleIndex']['exampleIndex1']->get(); //will return hello world
Optional::of($example)['exampleIndex']['exampleIndex1']->get(function($value) {
    // you can modify the value if you want
    return [$value]
}); //will return ['hello world']
Optional::of($example)['exampleIndex']['thisKeyDoesntExist']->get(); //will return null
```
if you want to get a default value use the `orElseGet()` method instead of the `get()` method
like the example below:
```php
Optional::of($example)['exampleIndex']['exampleIndex1']->orElseGet(); //will return hello world 
Optional::of($example)['exampleIndex']['thisKeyDoesntExist']->orElseGet(5); //will return 5
``` 
you can also pass a function to the `orElseGet()` method.

you have also the possibility to log errors.

```php
Optional::of($example)['exampleIndex']->log(function(Optional $optional) {
    $errors  = $optional->getErrors();
    // save $errors to a file or something like that
})->orElseGet(5); 
```

you can also use object attributes and methods

```php 
$example = new \stdClass();
Optional::of($example)->a->b()->c->get(); //will return null
Optional::of($example)->a->b()->c['index']->get(); //will return null
Optional::of($example)->a->b()->c->orElseGet(5); //will return 5
```

## List of Methods

| Command | Description |
| --- | --- |
| `of($value) : Optional` | creates a new Optional instance |
| `get(callable $callback = null)` | return the value, if the value does not exist, it returns null. you also have the possibility to modify the result with the callback function, callback($value) |
| `orElseGet($value)` | returns the value if exist not return the given value |
| `isEmpty() : bool` | is the value empty |
| `isNotEmpty() : bool` | is the value not empty |
| `getErrors() : array` | return an array of errors if the object was broken |
| `printErrors() : string` | print all errors |
| `log(callable $loggingFunction = null) : Optional` | if no callback is given it will print all errors. callback(Optional $this) |

## Testing

`composer test` or with coverage composer `test-conv`