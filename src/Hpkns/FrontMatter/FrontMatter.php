<?php namespace Hpkns\FrontMatter;

use Illuminate\Support\Facades\Facade;

class FrontMatter extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'front-matter';
    }
}
