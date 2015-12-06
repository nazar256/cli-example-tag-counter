<?php

namespace Commands;

use Client\DomCrawler;
use Client\WebClient;
use View\ReportView;

class CountTagsCommand extends AbstractCommand
{
    const ARG_IDX_URL       = 1;
    const ARG_IDX_TAG       = 2;
    const FILE_NAME_PATTERN = 'report_%s.html';
    const DATE_FORMAT       = 'd.m.Y';
    const PAGES_PER_TIME    = 20;

    private $newUrls    = [];

    private $parsedUrls = [];


    public function execute()
    {
        $this->outputMessage('command started');

        $pagesStats = [];
        $tagNameToCount = $this->input->getArgument(self::ARG_IDX_URL);
        $firstUrl = $this->input->getArgument(self::ARG_IDX_TAG);

        $this->newUrls = [$firstUrl];

        while ($this->newUrls) {
            $this->outputMessage(sprintf('loading %s new URLs', count($this->newUrls)));
            $pages = $this->loadPages();

            $this->outputMessage('all pages loaded');
            foreach ($pages as $url => $page) {
                $pagesStats[] = $this->processPage($page, $url, $tagNameToCount);
            }

            $diff = array_diff($this->newUrls, $this->parsedUrls);
            $newUniqueUrls = array_unique($diff);
            $this->outputMessage(sprintf('got %s new urls', count($newUniqueUrls)));
            $this->newUrls = $newUniqueUrls;
        }

        $this->outputMessage(sprintf('got %s rows of stats, sorting...', count($pagesStats)));
        $this->sortStats($pagesStats);

        $this->outputMessage('genering HTML report');
        $this->saveReport($pagesStats, $tagNameToCount);
        $this->outputMessage('done.');
    }

    private function loadPages()
    {
        $webClient = new WebClient();
        $allPages = [];
        $choppedUrls = array_chunk($this->newUrls, self::PAGES_PER_TIME);
        foreach ($choppedUrls as $iteration => $urlsChunk) {
            $currentPages = $webClient->multiGet($this->newUrls);
            $allPages = array_merge($allPages, $currentPages);

            $urlsChunkCount = count($urlsChunk);
            $pagesLoaded = $urlsChunkCount < self::PAGES_PER_TIME ?
                $urlsChunkCount
                : ($iteration + 1) * self::PAGES_PER_TIME;
            $this->outputMessage(sprintf('... loaded %s pages', $pagesLoaded));
        }

        return $allPages;
    }


    private function processPage($page, $url, $tagNameToCount)
    {
        $pageParseStartTime = microtime(true);
        $resultStats = [
            ReportView::KEY_URL          => $url,
            ReportView::KEY_TAG_COUNT    => 0,
            ReportView::KEY_PROCESS_TIME => 0
        ];

        try {
            $crawler = new DomCrawler($page);
        } catch (\InvalidArgumentException $exception) {
            $this->outputMessage('no page content for ' . $url);

            return $resultStats;
        }

        $resultStats[ReportView::KEY_TAG_COUNT] = $crawler->countTags($tagNameToCount);

        $currentDomain = parse_url($url, PHP_URL_HOST);
        $urlsOnPage = $crawler->findUrlsOfDomain($currentDomain);
        $this->newUrls = array_merge($this->newUrls, $urlsOnPage);

        $this->parsedUrls[] = $url;

        $pageParseEndTime = microtime(true);
        $resultStats[ReportView::KEY_PROCESS_TIME] = $pageParseEndTime - $pageParseStartTime;

        return $resultStats;
    }

    private function sortStats(array &$pagesStats)
    {
        return uasort(
            $pagesStats,
            function (array $rowA, array $rowB) {
                return $rowB[ReportView::KEY_TAG_COUNT] - $rowA[ReportView::KEY_TAG_COUNT];
            }
        );
    }

    private function saveReport(array $pagesStats, $tagNameToCount)
    {
        $templateVars = [
            'tagName' => $tagNameToCount,
            'stats'   => $pagesStats
        ];
        $view = new ReportView();
        $reportContent = $view->render($templateVars);
        file_put_contents($this->getOutputFileName(), $reportContent);
    }


    private function getOutputFileName()
    {
        $formattedDate = date(self::DATE_FORMAT);
        $fileName = sprintf(self::FILE_NAME_PATTERN, $formattedDate);

        return $fileName;
    }

    private function outputMessage($message)
    {
        $currentTime = microtime(true);
        $timeSinceStart = $currentTime - $this->getStartTime();
        $this->output->writeln($timeSinceStart . ': ' . $message);
    }
}