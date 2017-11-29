<?php

namespace App\Http\Controllers\Maintainance;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSourcingPractice;
use App\Http\Requests\UpdateSourcingPractice;
use App\Http\Controllers\Controller;
use App\ClientSourcingPractice;

class ClientSourcingPracticesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(isset($_GET['type']) && $_GET['type'] == 'all')
        {
            $sourcing_practices = ClientSourcingPractice::get();
        }
        else{
            $sourcing_practices = ClientSourcingPractice::paginate(5);
        }

        return $sourcing_practices;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSourcingPractice $request)
    {
        $sourcing_practice = ClientSourcingPractice::create([
                                'name' => $request['name']
                            ]);
        return ['message' => 'Sourcing Practice has been saved'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sourcing_practice = ClientSourcingPractice::find($id);

        return $sourcing_practice;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSourcingPractice $request, $id)
    {
        $sourcing_practice = ClientSourcingPractice::find($id)
                                ->update([
                                    'name' => $request['name']
                                ]);
        return ['message' => 'Changes has been save'];
    }   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}