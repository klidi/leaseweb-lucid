<?php
namespace Framework\Operations\Server;

use Framework\Domains\Server\Jobs\MakeRamModulesFromInputJob;
use Framework\Domains\Server\Jobs\MakeServerFromInputJob;
use Framework\Domains\Server\Jobs\MakePriceFromInputJob;
use Lucid\Foundation\Operation;
use Illuminate\Http\Request;
use Framework\Data\Server;

class MakeServerFromInputOperation extends Operation
{
    public function handle(Request $request) : Server
    {
        return $this->run(MakeServerFromInputJob::class, [
            'assetId' => $request->input('asset_id'),
            'name' => $request->input('name'),
            'brandId' => $request->input('brand_id'),
            'price' => $this->run(MakePriceFromInputJob::class, [
                'price' => $request->input('price')
            ]),
            'ramModules' => $this->run(MakeRamModulesFromInputJob::class, [
                'ramModules' => $request->input('ram_modules'),
            ]),
        ]);
    }
}
