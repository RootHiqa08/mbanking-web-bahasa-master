<?php

namespace App\Http\Controllers;

use App\Models\Verifications;
use App\Http\Requests\StoreVerificationsRequest;
use App\Http\Requests\UpdateVerificationsRequest;

class VerificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVerificationsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVerificationsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Verifications  $verifications
     * @return \Illuminate\Http\Response
     */
    public function show(Verifications $verifications)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Verifications  $verifications
     * @return \Illuminate\Http\Response
     */
    public function edit(Verifications $verifications)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVerificationsRequest  $request
     * @param  \App\Models\Verifications  $verifications
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVerificationsRequest $request, Verifications $verifications)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Verifications  $verifications
     * @return \Illuminate\Http\Response
     */
    public function destroy(Verifications $verifications)
    {
        //
    }
}
