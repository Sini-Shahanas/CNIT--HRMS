<?php

namespace OrangeHRM\Attendance\Controller;

use OrangeHRM\Attendance\Traits\Service\AttendanceServiceTrait;
use OrangeHRM\Core\Controller\AbstractVueController;
use OrangeHRM\Core\Traits\Auth\AuthUserTrait;
use OrangeHRM\Core\Vue\Component;
use OrangeHRM\Core\Vue\Prop;
use OrangeHRM\Entity\AttendanceRecord;
use OrangeHRM\Framework\Http\Request;

class PunchInController extends AbstractVueController
{
    use AttendanceServiceTrait;
    use AuthUserTrait;

    /**
     * @inheritDoc
     */
    public function preRender(Request $request): void
    {
        // check if previous record is a punch in.
        $attendanceRecord = $this->getAttendanceService()
            ->getAttendanceDao()
            ->getLastPunchRecordByEmployeeNumberAndActionableList(
                $this->getAuthUser()->getEmpNumber(),
                [AttendanceRecord::STATE_PUNCHED_IN]
            );
        //previous record is punched in, redirect to punch out
        if ($attendanceRecord instanceof AttendanceRecord) {
            $this->setResponse($this->redirect('/attendance/punchOut'));
            return;
        }

        $component = new Component('attendance-punch-in');
        //if configuration enabled, editable is true
        if ($this->getAttendanceService()->canUserChangeCurrentTime()) {
            $component->addProp(new Prop('is-editable', Prop::TYPE_BOOLEAN, true));
        }
        $this->setComponent($component);
    }
}