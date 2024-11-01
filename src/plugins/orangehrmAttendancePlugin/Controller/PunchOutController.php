<?php
namespace OrangeHRM\Attendance\Controller;

use OrangeHRM\Attendance\Traits\Service\AttendanceServiceTrait;
use OrangeHRM\Core\Controller\AbstractVueController;
use OrangeHRM\Core\Traits\Auth\AuthUserTrait;
use OrangeHRM\Core\Vue\Component;
use OrangeHRM\Framework\Http\Request;
use OrangeHRM\Entity\AttendanceRecord;
use OrangeHRM\Core\Vue\Prop;

class PunchOutController extends AbstractVueController
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

        //previous record is not present redirect to punch in
        if (!$attendanceRecord instanceof AttendanceRecord) {
            $this->setResponse($this->redirect('/attendance/punchIn'));
            return;
        }

        $component = new Component('attendance-punch-out');
        $component->addProp(new Prop('attendance-record-id', Prop::TYPE_NUMBER, $attendanceRecord->getId()));

        //if configuration enabled, editable is true
        if ($this->getAttendanceService()->canUserChangeCurrentTime()) {
            $component->addProp(new Prop('is-editable', Prop::TYPE_BOOLEAN, true));
        }
        $this->setComponent($component);
    }
}
