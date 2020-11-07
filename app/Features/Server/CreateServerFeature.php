<?php

namespace Framework\Features\Server;

use Framework\Operations\Server\ValidateCreateServerInputOperation;
use Framework\Operations\Server\MakeServerFromInputOperation;
use Framework\Http\Jobs\RespondWithJsonErrorJob;
use Framework\Http\Jobs\RespondWithJsonJob;
use Framework\Http\Resources\Server;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class CreateServerFeature extends Feature
{
    public function handle(Request $request)
    {
        $this->run(ValidateCreateServerInputOperation::class, [
            'request' => $request
        ]);

        $server = $this->run(MakeServerFromInputOperation::class, [
            'request' => $request
        ]);

        if (!$server->exists) {
            return $this->run(new RespondWithJsonErrorJob('Failed to create server'));
        }

        return $this->run(new RespondWithJsonJob(new Server(($server)), 201));
    }
}
