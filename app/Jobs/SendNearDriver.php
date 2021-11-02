<?php

namespace App\Jobs;

use App\Events\SendNotificationToDriver;
use App\Models\LookupValue;
use App\Models\PickUpRequest;
use App\Models\Trip;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Queue;

class SendNearDriver implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
   public $send,$pickup_request;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SendNotificationToDriver $send)
    {
        $this->send=$send;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
            broadcast($this->send);

    }
}
