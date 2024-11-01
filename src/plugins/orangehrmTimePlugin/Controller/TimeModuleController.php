<?php

namespace OrangeHRM\Time\Controller;

use Exception;
use OrangeHRM\Core\Controller\AbstractModuleController;
use OrangeHRM\Framework\Http\RedirectResponse;

class TimeModuleController extends AbstractModuleController
{
    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function handle(): RedirectResponse
    {
        $defaultPath = $this->getHomePageService()->getTimeModuleDefaultPath();
        return $this->redirect($defaultPath);
    }
}
