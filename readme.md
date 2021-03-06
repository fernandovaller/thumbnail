# Video Thumbnail URL

Get the thumbnail of youtube and vimeo videos from the url. The returned information is ID and URL of the thumbnail

## Installation

Install the latest version with

```bash
$ composer require fernandovaller/thumbnail
```

## Basic Usage

```php
<?php

use FVCode\Thumbnail\Thumbnail;

require __DIR__ . '/vendor/autoload.php';

$th = new Thumbnail();

$url = 'youtube|vimeo URL video';

// The returned information is ID and URL of the thumbnail
$data = $th->get($url);
```

## Config

Vimeo videos can have origin restriction, in which case add the setting to simulate the origin in the request.

```php
<?php

use FVCode\Thumbnail\Thumbnail;

require __DIR__ . '/vendor/autoload.php';

$config = [
    'origin' => 'https://www.google.com'
];

$th = new Thumbnail($config);

$url = 'youtube|vimeo URL video';

// The returned information is ID and URL of the thumbnail
$data = $th->get($url);
```

## Noembed

```php
<?php

use FVCode\Thumbnail\Thumbnail;

require __DIR__ . '/vendor/autoload.php';

$th = new Thumbnail();

$url = 'youtube|vimeo URL video';

// The returned information is array [title, thumbnail_url, video_id, ...]
$data = $th->getNoembed($url);
```
