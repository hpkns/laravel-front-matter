<?php namespace Hpkns\FrontMatter;

use Symfony\Component\Yaml\Parser as Yaml;

class Parser {

    /**
     * A yaml parser instance.
     *
     * @var \Symfony\Component\Yaml\Parser
     */
    protected $yaml;

    /**
     * Initialise the instance.
     *
     * @param  \Symfony\Component\Yaml\Parser
     * @return void
     */
    public function __construct(Yaml $yaml = null)
    {
        $this->yaml = $yaml ?: new Yaml;
    }

    /**
     * Parse a front matter file and return an array with its content.
     *
     * @param  string $fm
     * @param  array  $default
     * @return array
     */
    public function parse($fm, array $default = [])
    {
        $pieces = $parsed = [];
        $regexp = '/^---(?:\n|\r)(.+?)---(.*)$/ms';

        if(preg_match($regexp, $fm, $pieces) && $yaml = $pieces[1])
        {
            $parsed = $this->yaml->parse($yaml, true);

            if(is_array($parsed))
            {
                $parsed['content'] = trim($pieces[2]);

                return array_merge($default, $parsed);
            }
        }

        throw new Exceptions\FrontMatterHeaderNotFoundException('Parser failed to find a proper Front Matter header');
    }
}
