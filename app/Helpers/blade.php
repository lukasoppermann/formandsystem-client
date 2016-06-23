<?php
/**
 * convert markdown to html
 *
 * @method md_convert
 *
 * @param  string   $markdown [description]
 *
 * @return string
 */
use League\CommonMark\Converter;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;
use Webuni\CommonMark\AttributesExtension\AttributesExtension;
function md_convert($markdown){

    $environment = Environment::createCommonMarkEnvironment();
    $environment->addExtension(new AttributesExtension());

    $converter = new Converter(new DocParser($environment), new HtmlRenderer($environment));

    return $converter->convertToHtml($markdown);
}
