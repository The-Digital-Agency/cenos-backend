<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DeliveryWindow extends Model
{
    public function deliveryWindow()
    {
        $startTime = Carbon::parse($this->start_time)->isoFormat('h:mma');
        $endTime = Carbon::parse($this->end_time)->isoFormat('h:mma');

        return $startTime . ' - ' . $endTime;
    }
}
