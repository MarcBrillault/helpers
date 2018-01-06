<?php

declare(strict_types=1);

namespace Brio;

use PHPUnit\Framework\TestCase;

class SeoTest extends TestCase
{
    public function testSeoUrl()
    {
        $tests = [
            'Athènes'                                    => 'athenes',
            'Gdańsk'                                     => 'gdansk',
            'Poznań'                                     => 'poznan',
            'Wrocław'                                    => 'wroclaw',
            'Iaşi'                                       => 'iasi',
            'Das große Eszett'                           => 'das-grosse-eszett',
            'C\'est l\'œuvre de sa vie !'                => 'c-est-l-oeuvre-de-sa-vie',
            'El niño'                                    => 'el-nino',
            'I\'m giving my résumé to the café, Señor !' => 'i-m-giving-my-resume-to-the-cafe-senor',
        ];

        foreach ($tests as $data => $awaited) {
            $this->assertEquals($awaited, seoUrl($data));
        }
    }

    public function testSeoUnparseUrl()
    {
        $tests = [
            'fullExample'          => 'http://username:password@hostname:9090/path?arg=value#anchor',
            'multipleQueryStrings' => 'http://username:password@hostname:9090/path?arg=value&arg2=secondValue#anchor',
            'lengtyPath'           => 'http://username:password@hostname:9090/multiple/length/path.html?arg=value#anchor',
            'usernameNoPassword'   => 'http://username@hostname:9090/path?arg=value#anchor',
            'relativePath'         => '/images/icons.png',
            // 'protocolRelative'     => '//www.example.com/images/icons.png', // Will fail
        ];

        // Basic tests
        foreach ($tests as $test) {
            $array = parse_url($test);
            $this->assertEquals($test, unparseUrl($array));
        }

        // Non numeric port
        $nonNumericPortTest = $tests['fullExample'];
        $array              = parse_url($nonNumericPortTest);
        $array['port']      = 'wrongKingOfPort';
        $this->assertNotEquals($nonNumericPortTest, unparseUrl($array));

        // Query as array test
        $queryAsArrayTest = $tests['multipleQueryStrings'];
        $array            = parse_url($queryAsArrayTest);
        parse_str($array['query'], $array['query']);
        $this->assertEquals($queryAsArrayTest, unparseUrl($array));
    }
}