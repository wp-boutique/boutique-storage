<?php

use Boutique\Storage\SessionStorage;
use stdClass;

class SessionStorageTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->storage = new SessionStorage();
    }

    public function testSet()
    {
        $this->storage->set('foo', 'bar');

        $this->assertEquals( $this->storage->get('foo'), 'bar' );
        $this->assertTrue( isset($_SESSION['foo']) );
    }

    public function testMultidimentionalSet()
    {
        $this->storage->set('foo.bar', 'foo');

        $this->assertEquals( $this->storage->get('foo.bar'), 'foo' );
        $this->assertTrue( isset($_SESSION['foo']['bar']) );
    }

    public function testFlush()
    {
        $this->storage->set('test.foo', 'bar');
        $this->storage->set('test.bar', 'foo');

        $this->assertEquals( $this->storage->get('test.foo'), 'bar' );
        $this->assertEquals( $this->storage->get('test.bar'), 'foo' );
        $this->assertEquals( count($this->storage->get('test')), 2 );

        $this->storage->flush('test');

        $this->assertTrue( is_null($this->storage->get('test.foo')) );
        $this->assertTrue( is_null($this->storage->get('test.bar')) );
        $this->assertTrue( is_array( $this->storage->get('test.bar', array()) ) );
    }

    public function testSaveObjectsToSession()
    {
        $obj = new stdClass();
        $obj->foo = 'bar';

        $this->storage->set('foo', $obj);
        $this->assertTrue( gettype($this->storage->get('foo')) === 'object' );
    }
}
