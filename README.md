# Laravel Repository

[![Latest Stable Version](http://img.shields.io/packagist/v/BradleyKingDev/laravel-repository.svg)](https://packagist.org/packages/BradleyKingDev/laravel-repository)
## Version Compatibility

 Laravel      | Package
:-------------|:--------
 5.1          | 1.0
 5.2          | 1.2
 5.3          | 1.2
 5.4 to 5.8   | 1.4
 6.0          | 2.0
 7.0, 8.0     | 2.1

## Install

Via Composer

``` bash
composer require BradleyKingDev/laravel-repository
```

If you want to use the repository generator through the `make:repository` Artisan command, add the `RepositoryServiceProvider` to your `config/app.php`:

``` php
BradleyKingDev\Repository\RepositoryServiceProvider::class,
```

Publish the repostory configuration file.

``` bash
php artisan vendor:publish --tag="repository"
```


## Basic Usage

Simply extend the (abstract) repository class of your choice, either `BradleyKingDev\Repository\BaseRepository`, `BradleyKingDev\Repository\ExtendedRepository` or `BradleyKingDev\Repository\ExtendedPostProcessingRepository`.

The only abstract method that must be provided is the `model` method (this is just like the way Bosnadev's repositories are used).


### Make Repository

The `make:repository` command automatically creates a new Eloquent model repository class.
It will also attempt to link the correct Eloquent model, but make sure to confirm that it is properly set up.

``` bash
php artisan make:repository PostsRepository
```

The above command will create a repository class named PostsRepository and link the Post model to it.

If you want to set the related model explicitly, you can add the model class name:

``` bash
php artisan make:repository PostsRepository "App\Models\AlternativePost"
```


### Base-, Extended- and PostProcessing

Depending on what you require, three different abstract repository classes may be extended:

* `BaseRepository`

    Only has the retrieval and simple manipulation methods (`create()`, `update()` and `delete()`), and Criteria handling.

* `ExtendedRepository`

    Handles an **active** check for Models, which will by default exclude any model which will not have its `active` attribute set to true (configurable by setting `hasActive` and/or `activeColumn`).
    Handles caching, using [dwightwatson/rememberable](https://github.com/dwightwatson/rememberable) by default (but you can use your own Caching Criteria if desired).
    Allows you to set Model scopes, for when you want to use an Eloquent model scope to build your query.

* `ExtendedPostProcessingRepository`

    Just like Extended, but also allows for altering/decorating models after they are retrieved. By default, the only PostProcessor active is one that allows you to hide/unhide attributes on Models.

### Using the repository to retrieve models

Apart from the basic stuff (inspired by Bosnadev), there are some added methods for retrieval:

* `query()`: returns an Eloquent\Builder object reflecting the active criteria, for added flexibility
* `count()`
* `first()`
* `findOrFail()`: just like `find()`, but throws an exception if nothing found
* `firstOrFail()`: just like `first()`, but throws an exception if nothing found

Every retrieval method takes into account the currently active Criteria (including one-time overrides), see below.

For the `ExtendedPostProcessingRepository` goes that postprocessors affect all models returned, and so are applied in all the retrieval methods (`find()`, `firstOrFail()`, `all()`, `allCallback`, etc).
The `query()` method returns a Builder object and therefore circumvents postprocessing. If you want to manually use the postprocessors, simply call `postProcess()` on any Model or Collection of models.


#### Handling Criteria

Just like Bosnadev's repository, Criteria may be pushed onto the repository to build queries.
It is also possible to set default Criteria for the repository by overriding the `defaultCriteria()` method and returning a Collection of Criteria instances.

Criteria may be defined or pushed onto the repository by **key**, like so:

``` php
    $repository->pushCriteria(new SomeCriteria(), 'KeyForCriteria');
```

This allows you to later remove the Criteria by referring to its key:

``` php
    // you can remove Criteria by key
    $repository->removeCriteria('KeyForCriteria');
```

To change the Criteria that are to be used only for one call, there are helper methods that will preserve your currently active Criteria.
If you use any of the following, the active Criteria are applied (insofar they are not removed or overridden), and additional Criteria are applied only for the next retrieval method.

``` php
    // you can push one-time Criteria
    $repository->pushCriteriaOnce(new SomeOtherCriteria());

    // you can override active criteria once by using its key
    $repository->pushCriteriaOnce(new SomeOtherCriteria(), 'KeyForCriteria');

    // you can remove Criteria *only* for the next retrieval, by key
    $repository->removeCriteriaOnce('KeyForCriteria');
```

Note that this means that *only* Criteria that have keys can be removed or overridden this way.
A `CriteriaKey` Enum is provided to more easily refer to the standard keys used in the `ExtendedRepository`, such as 'active', 'cache' and 'scope'.


## Configuration
No configuration is required to start using the repository. You use it by extending an abstract repository class of your choice.

### Extending the classes
Some properties and methods may be extended for tweaking the way things work.
For now there is no documentation about this (I will add some later), but the repository classes contain many comments to help you find your way (mainly check the `ExtendedRepository` class).

### Traits
Additionally, there are some traits that may be used to extend the functionality of the repositories, see `BradleyKingDev\Repository\Traits`:

* `FindsModelsByTranslationTrait` (only useful in combination with the [dimsav/laravel-translatable](https://github.com/dimsav/laravel-translatable) package)
* `HandlesEloquentRelationManipulationTrait`
* `HandlesEloquentSavingTrait`
* `HandlesListifyModelsTrait` (only useful in combination with the [lookitsatravis/listify](https://github.com/lookitsatravis/listify) package)

I've added these mainly because they may help in using the repository pattern as a means to make unit testing possible without having to mock Eloquent models.


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.
