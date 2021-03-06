<?php

namespace Pilipinews\Website\Pna;

use Pilipinews\Common\Client;
use Pilipinews\Common\Crawler as DomCrawler;
use Pilipinews\Common\Interfaces\CrawlerInterface;

/**
 * Philippine News Agency Crawler
 *
 * @package Pilipinews
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Crawler implements CrawlerInterface
{
    /**
     * @var string[]
     */
    protected $categories = array(
        'https://www.pna.gov.ph/categories/national',
        'https://www.pna.gov.ph/categories/provincial',
    );

    /**
     * Returns an array of articles to scrape.
     *
     * @return string[]
     */
    public function crawl()
    {
        list($articles, $result) = array(array(), array());

        foreach ($this->categories as $category)
        {
            $result[] = $this->items($category);
        }

        foreach ($result[0] as $key => $item)
        {
            $articles[] = $result[0][$key];
            $articles[] = $result[1][$key];
        }

        return array_reverse((array) $articles);
    }

    /**
     * Returns an array of articles to scrape.
     *
     * @return string[]
     */
    protected function items($link)
    {
        $pattern = '.articles > .article.media';

        $base = 'https://www.pna.gov.ph';

        $callback = function (DomCrawler $node) use ($base)
        {
            $link = $node->filter('.media-heading > a');

            return $base . (string) $link->attr('href');
        };

        $crawler = new DomCrawler(Client::request($link));

        return $crawler->filter($pattern)->each($callback);
    }
}
