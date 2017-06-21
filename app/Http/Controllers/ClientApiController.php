<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Events\ClientAdded;
use App\Events\ClientEdited;
use Illuminate\Http\Request;
use App\Events\ClientDeleted;

class ClientApiController extends Controller
{
    public function getAllClients()
    {
        $clients = Client::all();

        return response()->json($clients, 200, [], JSON_NUMERIC_CHECK);
    }

    public function createClient(Request $request)
    {
        $client = new Client;
        $client->name = $request->name;
        $client->account_manager_id = $request->accountManager;
        $client->save();

        event(new ClientAdded($client));

        return response()->json($client, 201, [], JSON_NUMERIC_CHECK);
    }

    public function updateClient(Client $client, Request $request)
    {
        $client->name = $request->name;
        $client->account_manager_id = $request->accountManager;
        $client->save();

        event(new ClientEdited($client));

        return response()->json($client, 200, [], JSON_NUMERIC_CHECK);
    }

    public function deleteClient(Client $client)
    {
        $clientId = $client->id;
        $client->tasks->each(function ($task) {
            $task->delete();
        });

        $client->delete();

        event(new ClientDeleted($clientId));

        return response()->json("OK", 200, [], JSON_NUMERIC_CHECK);
    }
}
