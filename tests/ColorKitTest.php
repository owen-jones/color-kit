<?php

namespace OwenJones\ColorKit\Tests;

use OwenJones\ColorKit\ColorKit;
use PHPUnit\Framework\TestCase;

class ColorKitTest extends TestCase
{
  public function testContrastAccessible()
  {
    $this->assertTrue(ColorKit::isContrastAccessible('#000000', '#ffffff'));
    $this->assertFalse(ColorKit::isContrastAccessible('#000000', '#000000'));
    $this->assertFalse(ColorKit::isContrastAccessible('#0000FF', '#DB3D3D'));
    $this->assertTrue(ColorKit::isContrastAccessible('#000029', '#DB3D3D'));
    $this->assertFalse(ColorKit::isContrastAccessible('#4747FF', '#D1E8A1'));
    $this->assertTrue(ColorKit::isContrastAccessible('#4242FF', '#D1E8A1'));
  }

  public function testComputeTriad()
  {
    $colors = ColorKit::getColorTriad('#23A8F2');
    $this->assertTrue(ColorKit::isContrastAccessible($colors[0], $colors[1]), "Failed with $colors[0] and $colors[1]");
    $this->assertTrue(ColorKit::isContrastAccessible('#FFFFFF', $colors[1]), "Failed with $colors[1] over #FFFFFF. Full triad is $colors[0], $colors[1], $colors[2]");

    $colors = ColorKit::getColorTriad('#FF7162');
    $this->assertTrue(ColorKit::isContrastAccessible($colors[0], $colors[1]), "Failed with $colors[0] and $colors[1]");
    $this->assertTrue(ColorKit::isContrastAccessible('#FFFFFF', $colors[1]), "Failed with $colors[1] over #FFFFFF. Full triad is $colors[0], $colors[1], $colors[2]");

    $colors = ColorKit::getColorTriad('#23D660');
    $this->assertTrue(ColorKit::isContrastAccessible($colors[0], $colors[1]), "Failed with $colors[0] and $colors[1]");
    $this->assertTrue(ColorKit::isContrastAccessible('#FFFFFF', $colors[1]), "Failed with $colors[1] over #FFFFFF. Full triad is $colors[0], $colors[1], $colors[2]");

    $tests = 10000;
    for ($i = 0; $i < $tests; $i++) {
      $randomHex = dechex(rand(0x000000, 0xFFFFFF));
      $randomHex = str_pad($randomHex, 6, '0', STR_PAD_LEFT);
      $colors = ColorKit::getColorTriad($randomHex);
      $this->assertTrue(ColorKit::isContrastAccessible($colors[0], $colors[1]), "Failed with $colors[0] and $colors[1]");
      $this->assertTrue(ColorKit::isContrastAccessible('#FFFFFF', $colors[1]), "Failed with $colors[1] over #FFFFFF. Full triad is $colors[0], $colors[1], $colors[2]");
    }
  }
}
