<?php

namespace Framework\Domains\Server\Jobs;

use Framework\Data\Server;
use Illuminate\Support\Facades\Gate;
use Lucid\Foundation\Job;

class DeleteJob extends Job
{
    private Server $server;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * @throws \Exception
     */
    public function handle() : void
    {
        if (Gate::authorize('owns-resource', $this->server)) {
            $this->server->delete();
        }
    }
}
