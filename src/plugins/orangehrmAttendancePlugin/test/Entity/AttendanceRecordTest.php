<?php

namespace OrangeHRM\Tests\Attendance\Entity;

use DateTime;
use OrangeHRM\Entity\AttendanceRecord;
use OrangeHRM\Tests\Util\EntityTestCase;
use OrangeHRM\Tests\Util\TestDataService;

class AttendanceRecordTest extends EntityTestCase
{
    protected function setUp(): void
    {
        TestDataService::truncateSpecificTables([AttendanceRecord::class]);
    }

    public function testAttendanceRecordEntity(): void
    {
        //punch in
        $attendanceRecord = new AttendanceRecord();
        $attendanceRecord->getDecorator()->setEmployeeByEmpNumber(1);
        $attendanceRecord->setPunchInUtcTime(new DateTime('5:30'));
        $attendanceRecord->setPunchInNote('started work');
        $attendanceRecord->setPunchInTimeOffset('+05:30');
        $attendanceRecord->setPunchInUserTime(new DateTime('11:00'));
        $attendanceRecord->setState('PUNCH IN');
        $this->persist($attendanceRecord);

        $result = $this->getRepository(AttendanceRecord::class)->find(1);
        $this->assertInstanceOf(AttendanceRecord::class, $result);
        $this->assertEquals('started work', $result->getPunchInNote());

        //punch out
        $attendanceRecord = new AttendanceRecord();
        $attendanceRecord->getDecorator()->setEmployeeByEmpNumber(1);
        $attendanceRecord->setPunchOutUtcTime(new DateTime('12:30'));
        $attendanceRecord->setPunchOutNote('ended work');
        $attendanceRecord->setPunchOutTimeOffset('+05:30');
        $attendanceRecord->setPunchOutUserTime(new DateTime('18:00'));
        $attendanceRecord->setState('PUNCH OUT');
        $this->persist($attendanceRecord);

        $result = $this->getRepository(AttendanceRecord::class)->find(2);
        $this->assertInstanceOf(AttendanceRecord::class, $result);
        $this->assertEquals('ended work', $result->getPunchOutNote());
    }
}
