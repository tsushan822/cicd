<?php


namespace Tests\Browser;


use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Testing\Assert;
use Laravel\Dusk\Browser;

class DuskBrowser extends Browser
{
    /**
     * Selects an mdBootstrap select
     * @param Browser $browser
     * @param $method string "id" or "class"
     * @param $selector string id or class of the searched select element
     * @param $text string text of the select item to select
     */
    public function mdbSelectByNativeSelector(Browser $browser, $method, $selector, $text)
    {
        $text = trim($text);
        //Find the select element itself
        $selects = $browser->elements(".select-wrapper");
        $select = 0;

        foreach ($selects as $el)
        {
            if ($el->findElement(WebDriverBy::tagName("select"))->getAttribute($method) == $selector)
            {
                $select = $el;
            }
        }
        Assert::assertTrue(is_a($select, RemoteWebElement::class), "Select with {$method} {$selector} not found!");
        $select->click();

        //Find the content of the select
        $select_content = $select->findElement(WebDriverBy::className("dropdown-content"));
        //Select the nthElement (li) of the select content.

        $liElements = $select_content->findElements(WebDriverBy::tagName("li"));
        foreach ($liElements as $el)
        {
            if ($el->getText() == $text)
            {
                $el->click();
                return;
            }
        }
    }


    /**
     * Tests if an mdbSelect is selected
     * @param $method string "id" or "name"
     * @param $selector string the id or name of the native select element
     * @param $text string the content of the selectable element (value not possible because it's flushed away)
     * @return DuskBrowser
     */
    public function assertMDBSelected($method, $selector, $text)
    {

        //Find the select element itself
        $selects = $this->elements(".select-wrapper");
        $select = 0;
        $success = false;

        foreach ($selects as $el)
        {
            if ($el->findElement(WebDriverBy::tagName("select"))->getAttribute($method) == $selector)
            {
                $select = $el;
            }
        }

        Assert::assertTrue(is_a($el, RemoteWebElement::class), "Didn't find expected native select with {$method} {$selector}.");

        //Find the content of the select
        $select_content = $select->findElement(WebDriverBy::className("dropdown-content"));
        //Select the nthElement (li) of the select content.
        $liElements = $select_content->findElements(WebDriverBy::tagName("li"));
        foreach ($liElements as $el)
        {
            if (strpos($el->getAttribute("class"), "active") !== false)
            {
                //We need to ltrim because mdb inserts some problematic whitespaces in the text.
                if(ltrim($el->findElement(WebDriverBy::tagName("span"))->getAttribute("innerHTML")) == $text){
                    $success = true;
                    break;
                }
            }
        }
        Assert::assertTrue($success, "Select is not selected!");
        return $this;
    }

    protected function newBrowser($driver)
    {
        return new DuskBrowser($driver);
    }
}