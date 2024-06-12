<?php

namespace OwenJones\ColorKit;

use Mexitek\PHPColors\Color;

class ColorKit
{
  /**
   * Check if the contrast between two colors is AA accessible
   * @param string $color1 Hex value of the first color
   * @param string $color2 Hex value of the second color
   * @param float $threshold The contrast threshold. Default is 4.5
   *
   * @return bool True if the contrast is accessible, false otherwise
   * @throws \Exception If the color is not a valid hex value
   */
  public static function isContrastAccessible(string $color1, string $color2, float $threshold = 4.5): bool {
    $color1 = new Color($color1);
    $color2 = new Color($color2);

    $rgb1 = $color1->getRgb();
    $rgb2 = $color2->getRgb();

    $lumdiff = self::lumdiff($rgb1['R'], $rgb1['G'], $rgb1['B'], $rgb2['R'], $rgb2['G'], $rgb2['B']);

    return $lumdiff > $threshold;
  }

  /**
   * Get a color triad based on a base color
   * @param string $baseColor Hex value of the base color
   *
   * @return string[] An array containing the base color and two other colors. The first 2 colors are guaranteed to have an accessible contrast.
   *
   * @throws \Exception If the color is not a valid hex value
   */
  public static function getColorTriad(string $baseColor): array {
    $baseColor = new Color($baseColor);
    $hsl = $baseColor->getHsl();

    $h1 = $hsl['H'] + 120;
    $h2 = $hsl['H'] + 240;

    $a = [
      'H' => $h1,
      'S' => $hsl['S'],
      'L' => $hsl['L']
    ];

    $b = [
      'H' => $h2,
      'S' => $hsl['S'],
      'L' => $hsl['L']
    ];

    $colorBase = Color::hslToHex($hsl);
    $color1 = Color::hslToHex($a);
    $color2 = Color::hslToHex($b);

    $baseTextPair = self::findAccessiblePair($colorBase, $color1);
    $colorBase = $baseTextPair[0];
    $color1 = $baseTextPair[1];

    $baseHighlightPair = self::findAccessiblePair($colorBase, $color2);
    $colorBase = $baseHighlightPair[0];
    $color2 = $baseHighlightPair[1];

    // pick the darkest between color1 and color2
    $c1 = new Color($color1);
    $c2 = new Color($color2);
    if($c1->isLight() && !$c2->isLight()) {
      $color1 = $c2->getHex();
      $color2 = $c1->getHex();
    }

    $color1 = self::makeAccessibleAgainstWhite($color1);

    $baseTextPair = self::findAccessiblePair($colorBase, $color1);
    $colorBase = $baseTextPair[0];
    $color1 = $baseTextPair[1];

    $color1 = self::makeAccessibleAgainstWhite($color1);

    $baseTextPair = self::findAccessiblePair($colorBase, $color1);
    $colorBase = $baseTextPair[0];
    $color1 = $baseTextPair[1];

    return [sprintf("#%s", $colorBase), sprintf("#%s", $color1), sprintf("#%s", $color2)];
  }

  private static function findAccessiblePair(string $colorBase, string $color) {
    while(!self::isContrastAccessible($colorBase, $color, 5.0)){
      $c = new Color($color);
      $b = new Color($colorBase);
      if($c->isLight()) {
        $color = $c->lighten(1);
        $colorBase = $b->darken(1);
      }
      else {
        $color = $c->darken(1);
        $colorBase = $b->lighten(1);
      }
    }

    return [$colorBase, $color];
  }

  private static function makeAccessibleAgainstWhite(string $color) {
    while(!self::isContrastAccessible("#FFFFFF", $color, 5.0)){
      $c = new Color($color);
      $color = $c->darken(1);
    }

    return $color;
  }

  private static function lumdiff($R1,$G1,$B1,$R2,$G2,$B2){
    $L1 = 0.2126 * pow($R1/255, 2.2) +
      0.7152 * pow($G1/255, 2.2) +
      0.0722 * pow($B1/255, 2.2);

    $L2 = 0.2126 * pow($R2/255, 2.2) +
      0.7152 * pow($G2/255, 2.2) +
      0.0722 * pow($B2/255, 2.2);

    if($L1 > $L2){
      return ($L1+0.05) / ($L2+0.05);
    }else{
      return ($L2+0.05) / ($L1+0.05);
    }
  }
}