<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PresentationStatus;
use App\Http\Requests\Maintenance\Presentation\StorePresentationStatus;
use App\Http\Requests\Maintenance\Presentation\UpdatePresentationStatus;
use App\Events\MaintenanceEvent;

class PresentationStatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if(isset($_GET['type']) && $_GET['type'] == 'all'){
            $statuses = PresentationStatus::orderBy('status','asc')->get();
        }
        else{
            $statuses = PresentationStatus::orderBy('status','asc')->paginate(10);
        }

        return $statuses;
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
    public function store(StorePresentationStatus $request)
    {
        PresentationStatus::create([
            'status' => $request['status']
        ]);
        event(new MaintenanceEvent('presentation_statuses'));

        return ['message' => 'New Record has been saved'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $status = PresentationStatus::find($id);

        return $status;
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
    public function update(UpdatePresentationStatus $request, $id)
    {
        PresentationStatus::find($id)
                    ->update([
                        'status' => $request['status']
                    ]);

        event(new MaintenanceEvent('presentation_statuses'));
            
        return ['message' => 'Changes has been saved'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->userRole->id != 1)
            return response()->json(['message' => 'This action is unauthorized.'], 403);
        
        PresentationStatus::destroy($id);

        event(new MaintenanceEvent('presentation_statuses'));

        return ['message' => 'Record has been deleted'];
    }
}
