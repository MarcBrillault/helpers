<?php

namespace Brio;

use PHPUnit\Framework\TestCase;

class StrTest extends TestCase
{

    public function testStrComplete()
    {
        $tests = [
            [
                // complete from right
                'str'          => 'test',
                'length'       => 5,
                'fill'         => ' ',
                'fillFromLeft' => false,
                'expected'     => 'test ',
            ],
            [
                // complete from left
                'str'          => 'test',
                'length'       => 5,
                'fill'         => ' ',
                'fillFromLeft' => true,
                'expected'     => ' test',
            ],
            [
                // length shorter than $str + fillFromRight
                'str'          => 'test',
                'length'       => 3,
                'fill'         => ' ',
                'fillFromLeft' => false,
                'expected'     => 'test',
            ],
            [
                // length shorter than $str + fillFromLeft
                'str'          => 'test',
                'length'       => 3,
                'fill'         => ' ',
                'fillFromLeft' => true,
                'expected'     => 'test',
            ],
            [
                // UTF-8 characters in fill + fillFromRight
                'str'          => 'test',
                'length'       => 6,
                'fill'         => '…',
                'fillFromLeft' => false,
                'expected'     => 'test……',
            ],
            [
                // UTF-8 characters in fill + fillFromLeft
                'str'          => 'test',
                'length'       => 6,
                'fill'         => '…',
                'fillFromLeft' => true,
                'expected'     => '……test',
            ],
            [
                // UTF-8 characters in text + fillFromRight
                'str'          => '…test…',
                'length'       => 8,
                'fill'         => ' ',
                'fillFromLeft' => false,
                'expected'     => '…test…  ',
            ],
            [
                // UTF-8 characters in text + fillFromLeft
                'str'          => '…test…',
                'length'       => 8,
                'fill'         => ' ',
                'fillFromLeft' => true,
                'expected'     => '  …test…',
            ],
            [
                // UTF-8 characters in text & fill + fillFromRight
                'str'          => '…test…',
                'length'       => 8,
                'fill'         => '…',
                'fillFromLeft' => false,
                'expected'     => '…test………',
            ],
            [
                // UTF-8 characters in text & fill + fillFromLeft
                'str'          => '…test…',
                'length'       => 8,
                'fill'         => '…',
                'fillFromLeft' => true,
                'expected'     => '………test…',
            ],
        ];

        foreach ($tests as $data) {
            $functionResult = strComplete(
                $data['str'],
                $data['length'],
                $data['fill'],
                $data['fillFromLeft']
            );
            $this->assertEquals($data['expected'], $functionResult);
        }
    }

    public function testStrCut()
    {
        $str = <<<LIPSUM
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque condimentum lobortis risus. Ut quis ultrices sem.
Maecenas ultrices mauris non felis ultrices, sed scelerisque felis ullamcorper. Etiam at nulla eros. Duis in leo eget
lectus vulputate vestibulum. Nullam in quam non leo ornare condimentum. Vivamus eros quam, maximus vel ligula at,
elementum aliquet nisl. Vivamus lacinia viverra orci, fermentum volutpat mauris scelerisque at. Cras gravida posuere
vehicula. Aliquam ultrices tincidunt posuere. Cras sit amet facilisis est. Cras vel aliquam urna, eget aliquet mi.
LIPSUM;

        $tests = [
            [
                // default params
                'length'        => 50,
                'end'           => '…',
                'isTotalLength' => false,
                'expected'      => 'Lorem ipsum dolor sit amet, consectetur…',
            ],
            [
                // same with longer end
                'length'        => 50,
                'end'           => ' [...]',
                'isTotalLength' => false,
                'expected'      => 'Lorem ipsum dolor sit amet, consectetur [...]',
            ],
            [
                // long end, small text + totalLength
                'length'        => 20,
                'end'           => ' [...]',
                'isTotalLength' => false,
                'expected'      => 'Lorem ipsum dolor si [...]',
            ],
            [
                // Small length (cut in words)
                'length'        => 20,
                'end'           => ' [...]',
                'isTotalLength' => true,
                'expected'      => 'Lorem ipsum do [...]',
            ],
            [
                // Don't display last commas
                'length'        => 27,
                'end'           => ' [...]',
                'isTotalLength' => false,
                'expected'      => 'Lorem ipsum dolor sit amet [...]',
            ],
        ];

        foreach ($tests as $data) {
            $this->assertEquals($data['expected'], strCut($str, $data['length'], $data['end'], $data['isTotalLength']));
        }
    }

    public function testStrIsJson()
    {
        $array = [
            'different' => 'types',
            'of'        => 0,
            'values'    => [],
            'for'       => new \stdClass(),
            'testing'   => false,
        ];
        $json  = json_encode($array);

        $tests = [
            [
                // Correct JSON
                'value'    => $json,
                'expected' => true,
            ],
            [
                // No JSON
                'value'    => $array,
                'expected' => false,
            ],
            [
                // Incorrect JSON (1 less character)
                'value'    => mb_substr($json, 0, mb_strlen($json) - 1),
                'expected' => false,
            ],
        ];

        foreach ($tests as $data) {
            $this->assertEquals($data['expected'], strIsJson($data['value']));
        }
    }

    public function testStrIsUtf8()
    {
        $tests = [
            0                      => false,
            null                   => false,
            true                   => false,
            'test'                 => false,
            utf8_decode('áéóú')    => false,
            'áéóú'                 => true,
            'caractères accentués' => true,
            '😀'                   => true,
        ];

        foreach ($tests as $data => $awaited) {
            $this->assertEquals($awaited, strIsUtf8($data));
        }
    }

    public function testStrIsXml()
    {
        $tests = [
            'plain text'                                     => false,
            '<xml>Xml data</xml>'                            => true,
            '<div class="test" id="test">div content</div>'  => true,
            '<input type="text" value="self-closing tag" />' => true,
            '<b><i>Malformed HTML</i></i>'                   => true,
            'Plain < text > with > misleading > content'     => false,
        ];

        foreach ($tests as $data => $expected) {
            $this->assertEquals($expected, strIsXml($data));
        }
    }
}