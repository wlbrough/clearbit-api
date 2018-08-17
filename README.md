# Clearbit PHP API Client

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Clearbit API Client. Currently supporting the Enrichment API, but the entire API is on the roadmap for implementation. The current implementation uses v2 endpoints.

## Install

Via Composer

``` bash
$ composer require wlbrough/clearbit-api
```

## Quick Start

This implementation supports using one or multiple api keys. If a single key is used, clients are generated using static functions, otherwise instance methods generate clients.

### Using a single key

All of the following examples assume the following step:

```php
use wlbrough\clearbit\Clearbit;

Clearbit::setKey('token');
```

#### Configuring endpoint behavior

By default, Clearbit transmits data to a webhook if data is not immediately available. You can configure an endpoint url to receive webhooks, or you can use the steaming API to wait for results.

```php
$enrichment = Clearbit::createEnrichmentApi();

// Webhook endpoint
$enrichment->setWebhookEndpoint('https://test.com/api/webhook');

// Streaming
$enrichment->enableStreaming();
```

#### Get combined (person and company) data

```php
$enrichment = Clearbit::createEnrichmentApi();
$enrichment->combined('test@test.com');
```

#### Get person data

```php
$enrichment = Clearbit::createEnrichmentApi();
$enrichment->person('test@test.com');
```

To subscribe to updates:

```php
$enrichment = Clearbit::createEnrichmentApi();
$enrichment->person('test@test.com', true);
```

#### Get company data

```php
$enrichment = Clearbit::createEnrichmentApi();
$enrichment->company('test.com');
```

#### Name To Domain

```php
$nameToDomain = Clearbit::createNameToDomain();
$nameToDomain->get('Segment');
```

## Status

- [x] Enrichment
- [ ] Discovery
- [ ] Prospector
- [ ] Risk
- [ ] Reveal
- [x] Name To Domain
- [ ] Logo

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email wlbrough@gmail.com instead of using the issue tracker.

## Credits

- [Bill Broughton][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/wlbrough/clearbit-api.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/wlbrough/clearbit-api/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/wlbrough/clearbit-api.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/wlbrough/clearbit-api.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/wlbrough/clearbit-api.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/wlbrough/clearbit-api
[link-travis]: https://travis-ci.org/wlbrough/clearbit-api
[link-scrutinizer]: https://scrutinizer-ci.com/g/wlbrough/clearbit-api/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/wlbrough/clearbit-api
[link-downloads]: https://packagist.org/packages/wlbrough/clearbit-api
[link-author]: https://github.com/wlbrough
[link-contributors]: ../../contributors
