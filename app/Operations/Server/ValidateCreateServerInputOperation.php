<?php
namespace Framework\Operations\Server;

use Framework\Domains\Server\Jobs\ValidateCreateServerRamModulesInputJob;
use Framework\Domains\Server\Jobs\ValidateCreateServerBaseInputJob;
use Framework\Domains\Server\Jobs\ValidateCreateServerPriceInputJob;
use Lucid\Foundation\Operation;
use Illuminate\Http\Request;

class ValidateCreateServerInputOperation extends Operation
{
    public function handle(Request $request)
    {
        $this->run(ValidateCreateServerBaseInputJob::class,[
            'input' => $request->input(),
        ]);

        $this->run(ValidateCreateServerPriceInputJob::class,[
            'price' => $request->input('price'),
        ]);

        $this->run(ValidateCreateServerRamModulesInputJob::class, [
            'ramModules' => $request->input('ram_modules'),
        ]);
    }
}
