<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Http\Requests\ServerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServerController extends Controller
{
    public function index()
    {
        $servers = Server::orderBy('position')->get();
        return response()->json($servers);
    }

    public function store(ServerRequest $request)
    {
        try {
            $data = $request->validated();
            
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/servers', $imageName);
                $data['image'] = $imageName;
            }

            $server = Server::create($data);

            return response()->json([
                'message' => 'Servidor creado exitosamente',
                'server' => $server
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(ServerRequest $request, Server $server)
    {
        try {
            $data = $request->validated();
            
            if ($request->hasFile('image')) {
                // Eliminar imagen anterior si existe
                if ($server->image && Storage::exists('public/servers/' . $server->image)) {
                    Storage::delete('public/servers/' . $server->image);
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/servers', $imageName);
                $data['image'] = $imageName;
            }

            $server->update($data);

            return response()->json([
                'message' => 'Servidor actualizado exitosamente',
                'server' => $server
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Server $server)
    {
        try {
            // Eliminar imagen si existe
            if ($server->image && Storage::exists('public/servers/' . $server->image)) {
                Storage::delete('public/servers/' . $server->image);
            }

            $server->delete();

            return response()->json([
                'message' => 'Servidor eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'servers' => 'required|array'
        ]);

        try {
            foreach ($request->servers as $index => $serverData) {
                Server::where('id', $serverData['id'])->update(['position' => $index]);
            }

            return response()->json(['message' => 'Orden actualizado exitosamente']);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el orden',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}