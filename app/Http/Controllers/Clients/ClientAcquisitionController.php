<?php

namespace App\Http\Controllers\Clients;

use App\ClientAcquisition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\Acquisitions\StoreClientAcquisition;
use App\Http\Requests\Clients\Acquisitions\UpdateClientAcquisition;
use App\Events\ClientAcquisitionEvent;
use App\Events\ClientSubrecordEvent;
use App\Client;

class ClientAcquisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($clientId)
    {
        $request = app()->make('request');

        $acquisitions = ClientAcquisition::orderBy($request->sort_column, $request->order_by)
                            ->where(function($query) use ($request) {
                                if($request->has('keyword')){
                                    //$query->where('mann', 'LIKE', '%'.$request->keyword.'%');
                                    if($request->has('acquired_by') && $request->acquired_by != null) {
                                        $query->where('acquired_by' , $request->acquired_by);
                                    }
                                    //add additional filtering fields here
                                }
                            })
                            ->where('client_id', $clientId)
                            ->with('user')
                            ->with('manner_of_acquisition')
                            ->with('company')
                            ->with('status')
                            ->paginate($request->per_page);
        
        return response()->json([
                'model' => $acquisitions,
                'columns' => ClientAcquisition::$columns
            ]);
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
    public function store(StoreClientAcquisition $request, $clientId)
    {
        $client_acquisition = new ClientAcquisition;
        $client_acquisition->client_id = $clientId;
        $client_acquisition->company_id = $request['company_id'];
        // $client_acquisition->status_as_of = $request['status_as_of'];
        // $client_acquisition->status = $request['status'];
        $client_acquisition->date_acquired = $request['date_acquired'];
        $client_acquisition->acquired_by = $request['acquired_by'];
        $client_acquisition->signed_contract = $request['signed_contract'];
        $client_acquisition->manner_of_acquisition = $request['manner_of_acquisition'];
        $client_acquisition->name_of_related_client = $request['name_of_related_client'];
        $client_acquisition->initial_hc_acquired = $request['initial_hc_acquired'];
        $client_acquisition->remarks = $request['remarks'];
        $client_acquisition->updated_by = auth()->user()->id ;    
        $client_acquisition->save();
        // $acquisition = ClientAcquisition::create([
            // 'client_id' => $clientId,
            // 'company_id' => $request['company_id'],
            // 'status_as_of' => $request['status_as_of'],
            // 'status' => $request['status'],
            // 'date_acquired' => $request['date_acquired'],
            // 'acquired_by' => $request['acquired_by'],
            // 'signed_contract' => $request['signed_contract'],
            // 'manner_of_acquisition' => $request['manner_of_acquisition'],
            // 'name_of_related_client' => $request['name_of_related_client'],
            // 'initial_hc_acquired' => $request['initial_hc_acquired'],
            // 'remarks' => $request['remarks'],
            // 'updated_by' => auth()->user()->id
        // ]);
        $client = Client::find($clientId);
        $message = [
                'user' => auth()->user(),
                'response' => auth()->user()->name . " has tagged ".$client->client_name. ' ACQUIRED',
                'client' => $client
            ];

        broadcast(new ClientAcquisitionEvent($message,$clientId))->toOthers();
        event(new ClientSubrecordEvent($message));

        return ['message' => 'New client acquisition record has been saved'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClientAcquisition  $clientAcquisition
     * @return \Illuminate\Http\Response
     */
    public function show($clientId, $acquisition_id )
    {
        $acquisition = ClientAcquisition::findOrFail($acquisition_id);

        return $acquisition;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClientAcquisition  $clientAcquisition
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientAcquisition $clientAcquisition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClientAcquisition  $clientAcquisition
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientAcquisition $request, $clientId, $acquisition_id)
    {
        ClientAcquisition::findOrFail($acquisition_id)
                            ->update([
                                'client_id' => $request['client_id'],
                                'company_id' => $request['company_id'],
                                // 'status_as_of' => $request['status_as_of'],
                                // 'status' => $request['status'],
                                'date_acquired' => $request['date_acquired'],
                                'acquired_by' => $request['acquired_by'],
                                'signed_contract' => $request['signed_contract'],
                                'manner_of_acquisition' => $request['manner_of_acquisition'],
                                'name_of_related_client' => $request['name_of_related_client'],
                                'initial_hc_acquired' => $request['initial_hc_acquired'],
                                'remarks' => $request['remarks'],
                                'updated_by' => auth()->user()->id
                            ]);
        
        $client = Client::find($clientId);
        $message = [
                'user' => auth()->user(),
                'response' => auth()->user()->name . " has updated ".$client->client_name. ' Acquisition record',
                'client' => $client
            ];

        broadcast(new ClientAcquisitionEvent($message, $clientId))->toOthers();
        event(new ClientSubrecordEvent($message));
    
        return  [
                'message' => 'Changes has been saved',
            ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClientAcquisition  $clientAcquisition
     * @return \Illuminate\Http\Response
     */
    public function destroy($clientId, $acquisition_id)
    {
        if(!auth()->user()->userRole->delete_client_acquisitions == 1)
            return response()->json(['message' => 'This action is unauthorized.'], 403);

        ClientAcquisition::destroy($acquisition_id);
        $client = Client::findOrFail($clientId);
        
        $message = [
            'message' => $client->client_name . ' Acquisition record has been deleted by '. auth()->user()->name, 
        ];

        broadcast(new ClientAcquisitionEvent($message, $clientId))->toOthers();
        event(new ClientSubrecordEvent($message));

        return $message;
    }
}
