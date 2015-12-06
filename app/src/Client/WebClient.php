<?php

namespace Client;

/**
 */
class WebClient
{
    const TIMEOUT = 60;
    const LOAD_WAIT_TIME = 0.1;


    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    /**
     * @todo chop into methods
     * @param string[] $urls
     * @return string[]
     */
    public function multiGet(array $urls)
    {
        $curlHandlers = [];
        $multiHandler = curl_multi_init();
        foreach ($urls as $url) {
            $currentHandler = curl_init($url);
            $curlHandlers[$url] = $currentHandler;
            curl_setopt($currentHandler, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($currentHandler, CURLOPT_CONNECTTIMEOUT, self::TIMEOUT);
            curl_multi_add_handle($multiHandler, $currentHandler);
        }
        $isStillRunning = null;
        do {
            curl_multi_exec($multiHandler, $isStillRunning);
            sleep(self::LOAD_WAIT_TIME);
        } while ($isStillRunning);

        $results = [];
        // get content and remove handles
        foreach($urls as $url) {
            $currentHandler = $curlHandlers[$url];
            $results[$url] = curl_multi_getcontent($currentHandler);
            curl_multi_remove_handle($multiHandler, $currentHandler);
        }

        // all done
        curl_multi_close($multiHandler);

        return $results;
    }
}