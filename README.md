# About
It's a pure PHP CLI example application. 

## Usage
* app/cli.php <command name> [arg1, [arg2,...]]
* app/cli.php CountTags img nazar-blog.com

## What it does?
* parses site to find all pages (crawler)
* finds and counts specific tag by name
* generates report with pages, tag count and process time

## What it is able to?
* loads pages simultaneously with multi-cURL

## TODO
* add support for relative paths (issue with php.net)
* limit page load iterations (issue with star-marketing.com.ua)
* add sub-domain support