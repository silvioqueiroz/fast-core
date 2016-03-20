<?php
namespace fastblocks\core\util;

use PHPUnit_Framework_TestCase as PHPUnit;

class FastUtilTest extends PHPUnit
{

    public function setUp()
    {}

    public function tearDown()
    {}

    function testIsEmptyOrNullObjectNullTrue()
    {
        $_prop = 'one';
        $this->assertEquals(FastUtil::isEmptyOrNull(null, $_prop), true);
    }

    function testIsEmptyOrNullObjectNullfalse()
    {
        $_prop = 'one';
        $_object[$_prop] = 'fisrt';
        $this->assertEquals(FastUtil::isEmptyOrNull($_object, $_prop), false);
    }

    function testIsEmptyOrNullPropertieNullfalse()
    {
        $_prop = 'one';
        $_object[$_prop] = null;
        $this->assertEquals(FastUtil::isEmptyOrNull($_object, $_prop), true);
    }

    function testIsEmptyOrNullPropertieEmptyTrue()
    {
        $_prop = 'one';
        $_object['two'] = null;
        $this->assertEquals(FastUtil::isEmptyOrNull($_object, $_prop), true);
    }

    function testIsEmptyOrNullArrayEmptyTrue()
    {
        $_prop = 'one';
        $this->assertEquals(FastUtil::isEmptyOrNull(array(), $_prop), true);
    }

    function testIsEmptyOrNullArrayEmptyfalse()
    {
        $_object = array();
        $_prop = 'one';
        $_object[$_prop] = 'firts';
        $this->assertEquals(FastUtil::isEmptyOrNull($_object, $_prop), false);
    }

    function testEndsWithClassTrue()
    {
        $str = 'AlunoClass';
        $sub = 'Class';
        $this->assertEquals(FastUtil::endsWith($str, $sub), true);
    }

    function testEndsWithClassFalse()
    {
        $str = 'Alunoclass';
        $sub = 'Class';
        $this->assertEquals(FastUtil::endsWith($str, $sub), false);
    }
}
?>