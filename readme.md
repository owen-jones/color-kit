# ColorKit

ColorKit is a PHP library for handling and manipulating colors. It provides utilities for generating color triads and checking color contrast accessibility.

---

## Installation

todo: add installation instructions

---

## Usage

### Generating Color Triads

To get a color triad based on a base color:

```php
require 'vendor/autoload.php';

use YourNamespace\ColorKit;

$baseColor = '#3498db';
$triad = ColorKit::getColorTriad($baseColor);

print_r($triad);
// ['#3498db', '#db3434', '#34db34']
```

The first 2 colors are guaranteed to be accessible. The third is not.

### Checking Color Contrast

To check if the contrast between two colors is accessible (contrast ratio of at least 4.5):

```php
use YourNamespace\ColorKit;

$color1 = '#3498db';
$color2 = '#ffffff';

$isAccessible = ColorKit::isContrastAccessible($color1, $color2);

echo $isAccessible ? 'Accessible' : 'Not Accessible';
```

---

## Methods

`getColorTriad(string $baseColor): array`

Generates a color triad based on the base color.

- Parameters:
  - `string $baseColor`: Hex value of the base color.
- Returns:
  - `string[]`: An array containing the base color and two other colors.

`isContrastAccessible(string $color1, string $color2): bool`

Checks if the contrast between two colors is accessible.

- Parameters:
  - `string $color1`: Hex value of the first color.
  - `string $color2`: Hex value of the second color.
- Returns:
  - `bool`: `true` if the contrast ratio is at least 4.5, `false` otherwise.