<?php

namespace Client;

class DomCrawler
{
    /**
     * @var \DOMDocument
     */
    private $domDocument;

    /**
     * DomCrawler constructor.
     * @param $pageContent
     */
    public function __construct($pageContent)
    {
        if(!$pageContent){
            throw new \InvalidArgumentException('No page content provided');
        }
        $previous_value = libxml_use_internal_errors(TRUE);

        $this->domDocument = new \DOMDocument();
        $this->domDocument->loadHTML($pageContent);

        libxml_clear_errors();
        libxml_use_internal_errors($previous_value);
    }

    /**
     * @param string $tagName
     * @return \DOMNodeList
     */
    public function findByTagName($tagName)
    {
        return $this->domDocument->getElementsByTagName($tagName);
    }

    public function countTags($tagName)
    {
        return $this->findByTagName($tagName)->length;
    }

    public function findUrlsOfDomain($domainNameForLinks)
    {
        $urls = [];
        $linkTags = $this->findByTagName('a');
        /** @var \DOMElement $linkTag */
        foreach ($linkTags as $linkTag) {
            $url = $linkTag->getAttribute('href');
            $domain = parse_url($url, PHP_URL_HOST);
            $scheme = parse_url($url, PHP_URL_SCHEME);
            $path = parse_url($url, PHP_URL_PATH);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $isHtmlUrl = !$extension || $extension === 'html';
            if ($domain === $domainNameForLinks && $isHtmlUrl) {
                $urls[] = sprintf('%s://%s%s', $scheme, $domain , $path);
            }
        }

        return array_unique($urls);
    }
}