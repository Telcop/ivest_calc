<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CostShare;
use App\Http\Resources\CostSharesResource;
use App\Http\Requests\CostSharesStoreRequest;
use Illuminate\Http\Request;

class CostSharesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CostSharesResource::collection(CostShare::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CostSharesStoreRequest $request)
    {
        foreach($request->input("document.list_quotes.*") as $record) {
            $result[] = new CostSharesResource(CostShare::create($record));
        }
        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new CostSharesResource(CostShare::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}


