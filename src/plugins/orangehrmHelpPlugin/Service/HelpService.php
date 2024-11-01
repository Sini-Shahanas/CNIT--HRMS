<?php

namespace OrangeHRM\Help\Service;

use OrangeHRM\Help\Processor\HelpProcessor;

class HelpService
{
    protected ?HelpConfigService $helpConfigService = null;
    public ?HelpProcessor $helpProcessorClass = null;

    /**
     * @return HelpConfigService
     */
    public function getHelpConfigService(): HelpConfigService
    {
        return $this->helpConfigService ??= new HelpConfigService();
    }

    /**
     * @return HelpProcessor
     */
    public function getHelpProcessor(): HelpProcessor
    {
        if (!$this->helpProcessorClass instanceof HelpProcessor) {
            $helpProcessorClassName = 'OrangeHRM\\Help\\Processor\\' . $this->getHelpConfigService()->getHelpProcessorClass();
            $this->helpProcessorClass = new $helpProcessorClassName();
        }
        return $this->helpProcessorClass;
    }

    /**
     * @param string $label
     * @return string
     */
    public function getRedirectUrl(string $label): string
    {
        return $this->getHelpProcessor()->getRedirectUrl($label);
    }

    /**
     * @return string
     */
    public function getDefaultRedirectUrl(): string
    {
        return $this->getHelpProcessor()->getDefaultRedirectUrl();
    }

    /**
     * @return bool
     */
    public function isValidUrl(): bool
    {
        return filter_var($this->getHelpConfigService()->getBaseHelpUrl(), FILTER_VALIDATE_URL);
    }
}
