<?php namespace Malfaitrobin\Laracasts\Facades;

use Illuminate\Support\Facades\Facade;

class Laracasts extends Facade{

    /**
     * Gets the registerd name of the component.
     *
     * @return string
     */

    protected static function getFacadeAccessor() { return 'laracasts'; }
}
