![Prismic Toolkit](https://raw.githubusercontent.com/incraigulous/prismic-toolkit/master/art/hero.jpg)

### [Click here for the documentation.](https://incraigulous.gitbooks.io/prismic-toolkit/)

A suite of helpful tools for working with Prismic. You can use some or all of them. There are some Laravel specific tools, but you don't have to use Laravel to use this package.

#### Vanilla php features

- A wrapper around the official Prismic PHP sdk that provides a cleaner, fluent API.
- Automatic relationship resolution.
- Arrayable and Jasonable responses with relationship resolution.
- \Illuminate\Support\Collection objections are returned instead of arrays.

#### Laravel specific features
- A Laravel facade
- A Laravel service provider
- A Laravel Artisan command to precache data so you never have to call Prismic directly in production
- A Laravel tagged cacher
- A Laravel non-tagged cacher
- Customizable cache rules so you can miro-manage which resources should be cached.
- Endpoints to bust the cache and resync content via webhook
- Prismic webhook secret validation middleware
- A model trait to create relationships between database records and prismic resources
