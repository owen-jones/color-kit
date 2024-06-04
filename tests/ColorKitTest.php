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
    $this->assertTrue(ColorKit::isContrastAccessible($colors[0], $colors[1]));

    $colors = ColorKit::getColorTriad('#FF7162');
    $this->assertTrue(ColorKit::isContrastAccessible($colors[0], $colors[1]));

    $colors = ColorKit::getColorTriad('#23D660');
    $this->assertTrue(ColorKit::isContrastAccessible($colors[0], $colors[1]));
  }
}
