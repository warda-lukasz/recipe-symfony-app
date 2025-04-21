<?php

declare(strict_types=1);

namespace App\Messenger\Scheduler;

use App\Messenger\Scheduler\Message\SyncMealDb;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;

#[AsSchedule]
class ScheduleProvider implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {
        return (new Schedule())->add(
            RecurringMessage::every('20 minutes', new SyncMealDb()),
        );
    }
}
