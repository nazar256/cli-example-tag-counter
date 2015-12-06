<?php

namespace View;

/**
 * Class AbstractView
 */
abstract class AbstractView
{
    /**
     * @param array $templateVars
     * @return string
     * @throws \Exception
     */
    public function render(array $templateVars)
    {
        $templateName = $this->getTemplateName();
        $templatePath = sprintf('%s/tpl/%s.php', __DIR__, $templateName);

        return $this->renderTemplate($templateVars, $templatePath);
    }

    /**
     * Requires concrete view to define template
     * @return string
     */
    abstract protected function getTemplateName();

    /**
     * @param array  $templateVars
     * @param string $templatePath
     * @return string
     * @throws \Exception
     */
    private function renderTemplate(array $templateVars, $templatePath)
    {
        if (!file_exists($templatePath)) {
            $message = sprintf('Template %s was not found.', $templatePath);
            throw new \Exception($message);
        }
        ob_start();
        extract($templateVars);
        include($templatePath);
        $renderedContent = ob_get_contents();
        ob_end_clean();

        return $renderedContent;
    }
}