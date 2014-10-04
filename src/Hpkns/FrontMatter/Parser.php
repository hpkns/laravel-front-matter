<?php namespace Hpkns\FrontMatter;

use Symfony\Component\Yaml\Parser as Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class Parser {

    /**
     * Contains the raw text to be parsed
     *
     * @var string
     */
    protected $raw;
    /**
     * A YAML parser instance
     *
     * @var \Symfony\Component\Yaml\Parser $yaml
     */
    protected $yaml;

    /**
     * The parsed data extracted from the ff
     *
     * @var array
     */
    protected $parsed = [];

    /**
     * Initialise the instance
     *
     * @param  string $raw
     * @param  \Symfony\Component\Yaml\Parser $yaml
     * @return void
     */
    public function __construct($raw, Yaml $yaml = null)
    {
        $this->raw = $raw;
        $this->yaml = $yaml ?: new Yaml;

        $this->parse();
    }

    /**
     * Parse a file and return an array
     *
     * @return string
     */
    protected function parse()
    {
        $pieces = [];
        $regexp = '/^-{3}(?:\n|\r)(.+?)-{3}(.*)$/ms';

        if(preg_match($regexp, $this->raw, $pieces) && $yaml = $pieces[1])
        {
            $this->parsed = $this->yaml->parse($yaml);
            $this->parsed['content'] = trim($pieces[2]);

            return;
        }
        $this->parsed['content'] = $this->raw;
    }

    /**
     * Dynamicaly return the parsed elements
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        if(isset($this->parsed[$key]))
        {
            return $this->parsed[$key];
        }
    }

    /**
     * Return the content
     *
     * @return string
     */
    public function __toString()
    {
        return $this->parsed['content'];
    }
}
