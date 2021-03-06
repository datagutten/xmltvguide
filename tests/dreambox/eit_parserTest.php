<?php

namespace datagutten\dreambox\tests;

use datagutten\dreambox\eit_parser;
use PHPUnit\Framework\TestCase;

class eit_parserTest extends TestCase
{
    public function testMJD()
    {
        $ymd = eit_parser::parseMJD(58759);
        $this->assertSame(2019, $ymd[0]);
        $this->assertSame(10, $ymd[1]);
        $this->assertSame(3, $ymd[2]);
    }

    public function testParse()
    {
        $data = file_get_contents(__DIR__.'/test_data/Ice Road Rescue S04E01 - Ekstremvær HD.eit');
        $info = eit_parser::parse($data);
        $this->assertSame('Vinterveiens helter', $info['name']);
        $this->assertSame('(1:8/s4) Ekstremvær. Norsk dokumentarserie fra 2019.', $info['short_description']);
        $this->assertSame('Bergingsbilene har fått en ny fiende: ekstremvær. Brå temperaturendringer gir mannskapene uventede utfordringer.', $info['description']);
    }

    public function testGetHeader()
    {
        $data = file_get_contents(__DIR__.'/test_data/Ice Road Rescue S04E01 - Ekstremvær HD.eit');
        $info = eit_parser::parse_header($data);
        $this->assertSame(array(2019,10,3), $info['date']);
        $this->assertSame(array(1,0,0), $info['duration']);
        $this->assertSame(array(20,0,0), $info['time']);
    }


    /*public function testGet_codepage()
    {

    }

    public function testGet_string()
    {

    }*/

    public function testSeason_episode1()
    {
        $string = '(1:8/s4) Ekstremvær. Norsk dokumentarserie fra 2019.';
        $info = eit_parser::season_episode($string);
        $this->assertSame($info['season'], 4);
        $this->assertSame($info['episode'], 1);
    }
    public function testSeason_episode2()
    {
        $string = '(12) Idolet til Milo kommer til byen. Elliot får seg en ny jobb.';
        $info = eit_parser::season_episode($string);
        $this->assertSame($info['episode'], 12);
    }
    public function testSeason_episode3()
    {
        $string = '(2:12) Idolet til Milo kommer til byen. Elliot får seg en ny jobb.';
        $info = eit_parser::season_episode($string);
        $this->assertSame($info['episode'], 2);
    }
    public function testSeason_episode4()
    {
        $string = '(3:15/s3)';
        $info = eit_parser::season_episode($string);
        $this->assertSame($info['episode'], 3);
        $this->assertSame($info['season'], 3);
    }
}
