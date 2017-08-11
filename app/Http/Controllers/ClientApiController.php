<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Events\ClientAdded;
use App\Events\ClientEdited;
use Illuminate\Http\Request;
use App\Events\ClientDeleted;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateOrUpdateClient;

class ClientApiController extends Controller
{
    public function getAllClients()
    {
        $clients = Client::all();

        return response()->json($clients, 200, [], JSON_NUMERIC_CHECK);
    }

    public function createClient(CreateOrUpdateClient $request)
    {
        $accountManager = null;

        try {
            $accountManager = User::findOrFail($request->accountManager);
        } catch (\Exception $e) {
            return response()->json('user-not-found-error', 422);
        }

        $client = new Client;
        $client->name = $request->name;
        $client->account_manager_id = $accountManager->id;
        $client->group_id = Auth::user()->group_id;
        $client->save();

        event(new ClientAdded($client));

        return response()->json($client, 201, [], JSON_NUMERIC_CHECK);
    }

    public function updateClient(Client $client, CreateOrUpdateClient $request)
    {
        try {
            $accountManager = User::findOrFail($request->accountManager);
        } catch (\Exception $e) {
            return response()->json('user-not-found-error', 422);
        }

        $client->name = $request->name;
        $client->account_manager_id = $accountManager->id;
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
