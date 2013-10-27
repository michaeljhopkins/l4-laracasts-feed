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
    protected $cacheTime = 3600;

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
        $xml = $this->xml;
        $xmlArray = (array) $xml;
        unset($xmlArray['entry']);

        $xmlArray['link'] = (array) $xmlArray['link']->{"@attributes"};
        $xmlArray['link'] = (object) $xmlArray['link'];

        return (object) $xmlArray;
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
        if ($this->cache->has('xml_' . $this->url)) {
            $this->xml = $this->cache->get('xml_' . $this->url);
        } else {
            $this->xml = $this->fetchXML();

            $this->xml = $this->changeLinkElements($this->xml);

            $this->cache->put('xml_' . $this->url, $this->xml, $this->cacheTime);
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
