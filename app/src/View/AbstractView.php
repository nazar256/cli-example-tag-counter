<?php

namespace View;

abstract class AbstractView
{
    public function render(array $templateVars)
    {
        $templateName = $this->getTemplateName();
        $templatePath = sprintf('%s/tpl/%s.php', __DIR__, $templateName);

        return $this->renderTemplate($templateVars, $templatePath);
    }


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

    abstract protected function getTemplateName();
}