<?php
/**
 * This file is part of the "litgroup/json" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\LitGroup\Json;

use LitGroup\Json\Codec;
use LitGroup\Json\DecoderInterface;
use LitGroup\Json\EncoderInterface;
use LitGroup\Json\Exception\JsonException;

class CodecTest extends \PHPUnit_Framework_TestCase
{
    const DECODED_DATA = 'json';
    const ENCODED_DATA = '"json"';

    /**
     * @var Codec
     */
    private $codec;

    /**
     * @var EncoderInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $encoder;

    /**
     * @var DecoderInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $decoder;


    protected function setUp()
    {
        $this->encoder = $this->getMock(EncoderInterface::class);
        $this->decoder = $this->getMock(DecoderInterface::class);
        $this->codec = new Codec($this->encoder, $this->decoder);
    }

    protected function tearDown()
    {
        $this->encoder = null;
        $this->decoder = null;
        $this->codec = null;
    }

    /**
     * @test
     */
    public function testEncode()
    {
        $this->encoder
            ->expects($this->once())
            ->method('encode')
            ->with($this->identicalTo(self::DECODED_DATA))
            ->willReturn(self::ENCODED_DATA)
        ;

        $this->assertSame(self::ENCODED_DATA, $this->codec->encode(self::DECODED_DATA));
    }

    /**
     * @test
     * @expectedException \LitGroup\Json\Exception\JsonException
     */
    public function testEncodeThrowsException()
    {
        $this->encoder
            ->expects($this->once())
            ->method('encode')
            ->with($this->identicalTo(self::DECODED_DATA))
            ->willThrowException(new JsonException('', 0))
        ;

        $this->codec->encode(self::DECODED_DATA);
    }

    /**
     * @test
     */
    public function testDecode()
    {
        $this->decoder
            ->expects($this->once())
            ->method('decode')
            ->with($this->identicalTo(self::ENCODED_DATA))
            ->willReturn(self::DECODED_DATA)
        ;

        $this->assertSame(self::DECODED_DATA, $this->codec->decode(self::ENCODED_DATA));
    }

    /**
     * @test
     * @expectedException \LitGroup\Json\Exception\JsonException
     */
    public function testDecodeThrowsException()
    {
        $this->decoder
            ->expects($this->once())
            ->method('decode')
            ->with($this->identicalTo(self::ENCODED_DATA))
            ->willThrowException(new JsonException('', 0))
        ;

        $this->codec->decode(self::ENCODED_DATA);
    }
}