<?php namespace Malfaitrobin\Laracasts;

use Illuminate\Cache\CacheManager as Cache;

class Laracasts {

    /**
     * The laracasts url
     *
     * @var string
     */
    protected $url = "https://laracasts.com/feed";

    /**
     * All the meta information of the laracasts.com
     *
     * @var Object
     */
    protected $meta;

    /**
     * Illuminate\Cache\CacheManager object
     *
     * @var Object
     */
    protected $cache;

    /**
     * The cache time in minutes
     *
     * @var integer
     */
    protected $cacheTime = 60;

    protected $xml;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;

        $this->getXML();
    }

    /**
     * Get the lessons aka entries
     *
     * @return object
     */
    public function lessons()
    {
        return $this->xml->entry;
    }

    /**
     * Get the meta information of the xml feed
     *
     * @return object
     */
    public function meta()
    {
        $xml = (array) $this->xml;
        unset($xml['entry']);

        $xml['link'] = (object) $xml['link']->{"@attributes"};

        return (object) $xml;
    }

    /**
     * Set the cache time
     *
     * @param integer $time
     */
    public function setCacheTime($time)
    {
        $this->cacheTime = $time;
    }

    /**
     * Get the xml from the server, and cache the result
     *
     * @return void
     */
    protected function getXML()
    {
        $key = 'xml_' . md5($this->url); // Everybody loves md5!

        if ($this->cache->has($key)) {
            $this->xml = $this->cache->get($key);
        } else {
            $this->xml = $this->fetchXML();

            $this->xml = $this->changeLinkElements($this->xml);

            $this->cache->put($key, $this->xml, $this->cacheTime);
        }
    }

    protected function changeLinkElements($xml)
    {
        foreach ($xml->entry as $key => $entry) {
            $xml->entry[$key]->link = $entry->link->{"@attributes"}->href;
        }
        return $xml;
    }

    protected function fetchXML()
    {
        return json_decode(json_encode(simplexml_load_file($this->url)));
    }
}
