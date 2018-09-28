<?php

namespace Pilipinews\Website\Pna;

use Pilipinews\Common\Scraper as AbstractScraper;
use Pilipinews\Common\Article;
use Pilipinews\Common\Interfaces\ScraperInterface;

/**
 * Philippine News Agency Scraper
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
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

        if ($link === 'http://www.pna.gov.ph/articles/1047565')
        {
            file_put_contents('test.txt', $body->html());
        }

        return new Article($title, $this->html($body));
    }
}
