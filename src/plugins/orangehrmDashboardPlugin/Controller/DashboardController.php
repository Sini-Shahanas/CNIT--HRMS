<?php

namespace OrangeHRM\Dashboard\Controller;

use OrangeHRM\Core\Controller\AbstractVueController;
use OrangeHRM\Core\Helper\VueControllerHelper;
use OrangeHRM\Core\Traits\Auth\AuthUserTrait;
use OrangeHRM\Core\Traits\ServiceContainerTrait;
use OrangeHRM\Core\Traits\UserRoleManagerTrait;
use OrangeHRM\Core\Vue\Component;
use OrangeHRM\Framework\Http\Request;

class DashboardController extends AbstractVueController
{
    use AuthUserTrait;
    use ServiceContainerTrait;
    use UserRoleManagerTrait;

    public function preRender(Request $request): void
    {
        $component = new Component('view-dashboard');
        $this->setComponent($component);

        $dataGroups = [
            'dashboard_subunit_widget',
            'dashboard_location_widget',
            'dashboard_leave_widget',
            'dashboard_time_widget',
            'dashboard_buzz_widget',
            'dashboard_employees_on_leave_today_config',
        ];

        $permissions = $this->getUserRoleManagerHelper()
            ->geEntityIndependentDataGroupPermissionCollection($dataGroups);

        $this->getContext()->set(
            VueControllerHelper::PERMISSIONS,
            $permissions->toArray()
        );
    }
}
