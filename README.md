Prismic Toolkit
---------------

A suite of helpful tools for working with Prismic. You can use some or all of them. There are some laravel specific tools, but you don't have to use Laravel to use this package.

- A wrapper around the official prismic PHP sdk that provides a cleaner, fluent API.
- Automatic relationship resolution.
- A Laravel facade.
- A Laravel service provider. 
- Laravel config.
- A Laravel Artisan command to precache data so you never have to call Prismic directly in production. 
- A Laravel tagged based cacher.

## Installing

```
    composer install incraigulous/prismic-toolkit
```

##### Laravel

##### Register the service provider

```
    Incraigulous\PrismicToolkit\Providers\PrismicServiceProvider::class
```

##### Publish the config

```
    php artisan vendor:publish  --provider="Incraigulous\PrismicToolkit\Providers\PrismicServiceProvider"
```

Add your prismic keys to config/prismic.php

##### Migrate the database

```
    php artisan migrate
```

##### Request Caching

The Prismic SDK allows you to include a custom Cacher by passing it it when creating a new `Prismic\Api` instance. If you're using Laravel, this can be handled automatically by specifying a cacher in the `config/prismic.php`. 
```
    /**
     * A cacher that implements Prismic\Cache\CacheInterface
     *
     * Options:
     * \Incraigulous\PrismicToolkit\Cachers\LaravelCacher::class,
     * \Incraigulous\PrismicToolkit\Cachers\LaravelTaggedCacher::class,
     * \Prismic\Cache\ApcCache::class,
     * \Prismic\Cache\NoCache::class
     */
    'cacher' => \Incraigulous\PrismicToolkit\Cachers\LaravelTaggedCacher::class,
```

#### Precaching

Both the `LaravelCacher` and the `TaggedLaravelCacher` will keep a record of all endpoints called by the API. This allows you to precache endpoints so Prismic never actually has to be called during run time. To precache endpoints run the following command.

```
    php artisan prismic:sync
```

Calling this command will flush and call and recache each endpoint that has been called by the application.

## Fluent wrapper

After calling the API, pass the results into the response class.

```
    $single = Response::make(
        Prismic::getByUID('example', 'test-slug')
    );
    
    $title = $single->title;
```

##### Relationship resolution

Calling the field name of the relationship or link field will automatically resolve relationships.

```
    $relatedAuthorName = $single->author->name;
```

### Wrapper Types

Wrapper objects are either `collections` which extend `illuminate\collection` or objects to overload to a base Prismic object.

#### Collections

See Laravel's collection documentation.

#### Wrapper Objects

##### Helper Methods

`getObject()`

Return the raw prismic object.

```
    $document->getObject()->getUid();
```

`get($name)`

Get an attribute on the prismic object and resolve it. This is essentially as using the standard arrow syntax to access a field.

```
    $document->get('title');
    
    is the same as calling
    
    $document->title;
```

`getRaw($name)`

Get an attribute on the prismic object but don't resolve it. The prismic API fragment object will be returned. This should be used to access prismic's raw field helper classes.

```
    $document->getRaw('title')->asText();
```

`has($name)` or `exists($name)` 

Does an attribute exist on the prismic instance? Returns a `boolean`.

```
    $document->exists('title');
```





