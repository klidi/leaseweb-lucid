<?php

namespace Framework\Features\Server;

use Framework\Data\Server;
use Framework\Domains\Server\Jobs\DeleteJob;
use Framework\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class DeleteServerFeature extends Feature
{
    private Server $server;

    /**
     * DeleteServerFeature constructor.
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * @return string
     */
    public function handle() : string
    {
        $this->run(DeleteJob::class, [
            'server' => $this->server
        ]);

        return $this->run(new RespondWithJsonJob(null, 200));
    }
}
