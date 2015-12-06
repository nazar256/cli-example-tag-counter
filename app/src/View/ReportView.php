<?php

namespace View;

class ReportView extends AbstractView
{
    const TEMPLATE         = 'report';
    const KEY_URL          = 'url';
    const KEY_TAG_COUNT    = 'tag_count';
    const KEY_PROCESS_TIME = 'process_time';


    protected function getTemplateName()
    {
        return self::TEMPLATE;
    }
}