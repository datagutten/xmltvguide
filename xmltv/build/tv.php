<?php


namespace datagutten\xmltv\tools\build;


use datagutten\xmltv\tools\common\files;
use DOMDocument;
use Exception;
use FileNotFoundException;
use SimpleXMLElement;

class tv
{
    /**
     * @var SimpleXMLElement
     */
    public $xml;

    public $channel;

    public $language;

    public $generator;

    public $files;

    /**
     * tv constructor.
     * @param string $channel Channel id
     * @param string $language Language
     * @param string $generator
     * @throws FileNotFoundException
     * @throws Exception
     */
    function __construct($channel, $language, $generator = 'php-xmltv-grabber')
    {
        $this->channel = $channel;
        $this->language = $language;
        $this->generator = $generator;
        $this->init_xml();
        $this->files = new files();
    }

    function init_xml()
    {
        $this->xml = new SimpleXMLElement(file_get_contents(__DIR__.'/template.xml'));
        $this->xml->addAttribute('generator-info-name', $this->generator);
        $this->xml->addAttribute('generator-info-url', 'https://github.com/datagutten/xmltvgrabber');
    }

    function format_output()
    {
        if(empty($this->xml->{'programme'}))
            return null;
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($this->xml->asXML());
        return $dom->saveXML();
    }

    function save_file($timestamp)
    {
        $file = $this->files->file($this->channel, $timestamp);
        //$xml_string = $this->xml->asXML();
        $xml_string = $this->format_output();
        $this->files->filesystem->dumpFile($file, $xml_string);
        return $file;
    }
}