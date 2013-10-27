# Laravel4: Laracasts feed wrapper!

This is a simple laracasts feed wrapper; Get a list of the lessons from the feed and get some meta data.

## Installation

### Composer

Open your `composer.json` and add this to the `"require"`

```php
"malfaitrobin/laracasts": "dev-master"
```
	
Now do a 

```php
composer update
```

### Laravel4

Open your `app/config/app.php` now add this to your providers
	
```php
'Malfaitrobin\Laracasts\LaracastsServiceProvider',
```

And this to your aliases:

```php
'Laracasts' 	  => 'Malfaitrobin\Laracasts\Facades\Laracasts',
```

And you are ready to go!

## Usage

There are some functions you can use. For Example:

```php
$lessons = Laracasts::lessons();	
```

This returns an array with the latest lessons which you can use it like:

```php
</ul>
    @foreach($lessons as $lesson)
        <li>
            <h2>
                <a href="{{ $lesson->link }}">{{ $lesson->title }}</a>
            </h2>
            <p>
                {{ $lesson->summary }}
            </p>
        </li>
    @endforeach
</ul>
```

You also have a function for the meta data:

```php
$meta = Laracasts::meta();
```

This contains the following information:

```php
object(stdClass)[185]
  public 'title' => string 'Laracasts' (length=9)
  public 'subtitle' => string 'The best source of Laravel training on the web.' (length=47)
  public 'link' => 
    object(stdClass)[184]
      public 'href' => string 'http://laracasts.com/feed' (length=25)
      public 'rel' => string 'self' (length=4)
  public 'updated' => string '2013-10-27T23:27:33+00:00' (length=25)
  public 'author' => 
    object(stdClass)[153]
      public 'name' => string 'Jeffrey Way' (length=11)
  public 'id' => string 'tag:laracasts.com,2013:/feed' (length=28)
```
      
      
There is 1 more function:

```php
Laracasts::setCacheTime($timeInMinutes);
```

Because we fetch the feed, we don't want to hit laracasts.com server everytime. The standard cache time is 1 hour!


---
Hope You Enjoy :)