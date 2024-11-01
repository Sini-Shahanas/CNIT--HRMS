<?php

namespace OrangeHRM\Dashboard\Dao;

use DateTime;
use OrangeHRM\Core\Dao\BaseDao;
use OrangeHRM\Entity\AttendanceRecord;
use OrangeHRM\ORM\ListSorter;

class EmployeeTimeAtWorkDao extends BaseDao
{
    /**
     * @param int $empNumber
     * @return AttendanceRecord|null
     */
    public function getLatestAttendanceRecordByEmpNumber(int $empNumber): ?AttendanceRecord
    {
        $qb = $this->createQueryBuilder(AttendanceRecord::class, 'attendanceRecord')
            ->andWhere('attendanceRecord.employee = :empNumber')
            ->setParameter('empNumber', $empNumber)
            ->setMaxResults(1)
            ->addOrderBy('attendanceRecord.punchInUtcTime', ListSorter::DESCENDING);
        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param int $empNumber
     * @param DateTime $startUTCDateTime
     * @param DateTime $endUTCDateTime
     * @return AttendanceRecord[]
     */
    public function getAttendanceRecordsByEmployeeAndDate(
        int $empNumber,
        DateTime $startUTCDateTime,
        DateTime $endUTCDateTime
    ): array {
        $qb = $this->createQueryBuilder(AttendanceRecord::class, 'attendanceRecord');
        $qb->andWhere('attendanceRecord.employee = :empNumber');
        $qb->setParameter('empNumber', $empNumber);
        $qb->andWhere(
            $qb->expr()->orX(
                $qb->expr()->between(
                    'attendanceRecord.punchInUtcTime',
                    ':start',
                    ':end'
                ),
                $qb->expr()->between(
                    'attendanceRecord.punchOutUtcTime',
                    ':start',
                    ':end'
                ),
                $qb->expr()->andX(
                    $qb->expr()->lte('attendanceRecord.punchInUtcTime', ':start'),
                    $qb->expr()->gte('attendanceRecord.punchOutUtcTime', ':end')
                )
            )
        );
        $qb->setParameter('start', $startUTCDateTime);
        $qb->setParameter('end', $endUTCDateTime);
        return $qb->getQuery()->execute();
    }

    /**
     * @param int $empNumber
     * @return AttendanceRecord|null
     */
    public function getOpenAttendanceRecordByEmpNumber(int $empNumber): ?AttendanceRecord
    {
        $qb = $this->createQueryBuilder(AttendanceRecord::class, 'attendanceRecord');
        $qb->andWhere('attendanceRecord.state = :state');
        $qb->setParameter('state', AttendanceRecord::STATE_PUNCHED_IN);
        $qb->andWhere('attendanceRecord.employee = :empNumber');
        $qb->setParameter('empNumber', $empNumber);
        return $qb->getQuery()->getOneOrNullResult();
    }
}
