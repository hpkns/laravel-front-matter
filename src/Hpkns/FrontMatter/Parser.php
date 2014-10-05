<?php namespace Hpkns\FrontMatter;

use Symfony\Component\Yaml\Parser as Yaml;

class Parser {

    /**
     * A yaml parser instance
     *
     * @var \Symfony\Component\Yaml\Parser
     */
    protected $yaml;

    /**
     * Initialise the instance
     *
     * @param  \Symfony\Component\Yaml\Parser
     * @return void
     */
    public function __construct(Yaml $yaml = null)
    {
        $this->yaml = $yaml ?: new Yaml;
    }
    /**
     * Parse a front matter file and return an array with its content
     *
     * @param  string $fm
     * @param  array  $default
     * @return array
     */
    public function parse($fm, array $default = [], $castObject = false)
    {
        $pieces = [];
        $parsed = [];
        $regexp = '/^-{3}(?:\n|\r)(.+?)-{3}(.*)$/ms';

        if(preg_match($regexp, $fm, $pieces) && $yaml = $pieces[1])
        {
            $parsed = $this->yaml->parse($yaml, true);
            $parsed['content'] = trim($pieces[2]);
        }
        else
        {
            // If the regexp fails (i.e. if there is no front matter header present)
            // we just return an array with the content as the only key
            $parsed['content'] = $this->raw;
        }

        $parsed = $this->fillDefault($parsed, $default);

        if($castObject)
        {
            return (object)$parsed;
        }

        return $parsed;
    }

    /**
     * Add default value to key that are not defined in the front matter
     *
     * @param  array $parsed
     * @param  array $default
     * @return array
     */
    protected function fillDefault(array $parsed, array $default = [])
    {
        foreach($default as $key => $value)
        {
            if( ! isset($parsed[$key]))
            {
                $parsed[$key] = $value;
            }
        }

        return $parsed;
    }
}
