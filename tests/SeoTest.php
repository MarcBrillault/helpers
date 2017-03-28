<?php

class SeoTest extends \PHPUnit\Framework\TestCase
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
            $this->assertEquals($awaited, \Brio\seoUrl($data));
        }
    }
}