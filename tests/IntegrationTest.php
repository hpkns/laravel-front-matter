<?php

use \Hpkns\FrontMatter\Parser;

class IntegrationTest extends PHPUnit_Framework_TestCase {

    public function testIsInstanciable()
    {
        $p = new Parser('');

        $this->assertInstanceOf('\Hpkns\FrontMatter\Parser', $p);
    }

    public function testParsesData()
    {
        $title = 'some title';
        $content = 'some content';
        $doc = <<<EOL
---
title: {$title}
array: [a,b,c]
---
{$content}
EOL;
        $p = new Parser($doc);

        $this->assertEquals($title, $p->title);
        $this->assertEquals($content, $p->content);
        $this->assertEquals(['a','b','c'], $p->array);
    }

    public function testReturnContentWhenCastToString()
    {
        $content = 'some content';
        $p = new Parser($content);

        $this->assertEquals($content, (string)$p);

        $p = new Parser("---\ntest: case\n---\n{$content}");

        $this->assertEquals($content, (string)$p);
    }
}
