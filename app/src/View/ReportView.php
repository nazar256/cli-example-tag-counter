<?php

namespace View;

/**
 * TagCount report view
 */
class ReportView extends AbstractView
{
    const TEMPLATE         = 'report';
    const KEY_URL          = 'url';
    const KEY_TAG_COUNT    = 'tag_count';
    const KEY_PROCESS_TIME = 'process_time';

    /**
     * @return string
     */
    protected function getTemplateName()
    {
        return self::TEMPLATE;
    }
}