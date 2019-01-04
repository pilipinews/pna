<?php

namespace Pilipinews\Website\Pna;

use Pilipinews\Common\Article;
use Pilipinews\Common\Crawler as DomCrawler;
use Pilipinews\Common\Interfaces\ScraperInterface;
use Pilipinews\Common\Scraper as AbstractScraper;

/**
 * Philippine News Agency Scraper
 *
 * @package Pilipinews
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Scraper extends AbstractScraper implements ScraperInterface
{
    /**
     * Returns the contents of an article.
     *
     * @param  string $link
     * @return \Pilipinews\Common\Article
     */
    public function scrape($link)
    {
        $this->prepare(mb_strtolower($link));

        $title = (string) $this->title('h1');

        $body = $this->body('.page-content');

        $body = $this->image($body);

        $html = (string) $this->html($body);

        return new Article($title, $html, $link);
    }

    /**
     * Converts image elements to readable string.
     *
     * @param  \Pilipinews\Common\Crawler $crawler
     * @return \Pilipinews\Common\Crawler
     */
    protected function image(DomCrawler $crawler)
    {
        $callback = function (DomCrawler $crawler)
        {
            $result = $crawler->filter('img')->first();

            $image = (string) $result->attr('src');

            $text = $crawler->filter('p')->first();

            $message = $image . ' - ' . $text->html();

            return '<p>PHOTO: ' . $message . '</p>';
        };

        return $this->replace($crawler, 'figure.image', $callback);
    }
}
