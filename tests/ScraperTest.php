<?php

namespace Pilipinews\Website\Pna;

/**
 * Scraper Test
 *
 * @package Pilipinews
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ScraperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $link = 'https://www.pna.gov.ph/articles/';

    /**
     * @var \Pilipinews\Common\Interfaces\ScraperInterface
     */
    protected $scraper;

    /**
     * Sets up the scraper instance.
     *
     * @return void
     */
    public function setUp()
    {
        $this->scraper = new Scraper;
    }

    /**
     * Returns an array of content with their URLs.
     *
     * @return string[][]
     */
    public function items()
    {
        list($items, $regex) = array(array(), "/[\r\n]+/");

        $files = (array) glob(__DIR__ . '/Articles/*.txt');

        foreach ((array) $files as $file)
        {
            $url = $this->link((string) $file);

            $text = file_get_contents($file);

            $expected = preg_replace($regex, "\n", $text);

            $items[] = array($expected, $url);
        }

        return (array) $items;
    }

    /**
     * Tests ScraperInterface::scrape.
     *
     * @dataProvider items
     * @param        string $expected
     * @param        string $url
     * @return       void
     */
    public function testScrapeMethod($expected, $url)
    {
        $article = $this->scraper->scrape((string) $url);

        $post = (string) $article->post();

        $result = preg_replace("/[\r\n]+/", "\n", $post);

        $this->assertEquals($expected, (string) $result);
    }

    /**
     * Converts the filename into a valid URL.
     *
     * @param  string $filename
     * @return string
     */
    protected function link($filename)
    {
        return $this->link . substr(basename($filename), 0, 7);
    }
}
