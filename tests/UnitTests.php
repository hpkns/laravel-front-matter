<?php

use \Hpkns\FrontMatter\Parser;

class UnitTests extends PHPUnit_Framework_TestCase {

    public function __construct()
    {
        $this->p = new Parser;
    }

    public function testIsInstanciable()
    {
        $this->assertInstanceOf('\Hpkns\FrontMatter\Parser', $this->p);
    }

    public function testParsesData()
    {
        $title = 'some title';
        $content = 'some content';
        $default = 'default value';
        $doc = <<<EOL
---
title: {$title}
array: [a,b,c]
---
{$content}
EOL;

        $r = $this->p->parse($doc, ['default'=>$default]);

        // Test for a key in the front matter
        $this->assertEquals($title, $r['title']);
        // Test for the content
        $this->assertEquals($content, $r['content']);
        // Test for an array key in the front matter
        $this->assertEquals(['a','b','c'], $r['array']);
        // Test for a default value (not present in the front matter)
        $this->assertEquals($default, $r['default']);
    }

    public function testCastToObject()
    {
        $r = $this->p->parse('test', [], true);

        $this->assertInstanceOf('stdClass', $r);
    }

    /**
     * @expectedException \Symfony\Component\Yaml\Exception\ParseException
     */
    public function testThrowExceptionBadlyFormattedYaml()
    {
        $badly_formatted = <<<EOL
---
'
---
(hopefully)
EOL;
        $this->p->parse($badly_formatted);
    }
}
