<?php

namespace App\Http\Controllers\Administration\Profiles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administration\Profiles\CreateNewProfileRequest;
use App\Http\Requests\Administration\Profiles\UpdateProfileRequest;
use App\Http\Requests\Administration\Profiles\SearchProfileRequest;
use App\Http\Requests\Administration\Profiles\UpdatePermissionsRequest;
use App\Http\Resources\Administration\Profiles\PermissionGroupsCollection;
use App\Http\Resources\Administration\Profiles\ProfileResource;
use App\Http\Resources\Administration\Profiles\ProfilesCollection;
use App\Models\Administration\Permissions\PermissionGroup;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::with('permissions')->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateNewProfileRequest $request)
    {
        $role = Role::create([
                    'name' => $request->name
                ]);

        return response()->json($role, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ProfileResource(Role::with('permissions')->whereId($id)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request, $id)
    {
        $role = Role::whereId($id)->update([
                    'name' => $request->name
                ]);

        return response()->json("OK", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(null == $role = Role::find($id)) {
            return response()->json(['errors' => ['Perfil no encontrado']], 404);
        }

        if(auth()->user()->hasPermissionTo("administration.profiles.delete")) {
            $role->delete();

            return response()->json("Perfil eliminado con éxito.", 200);
        }

        return response()->json("No tiene permisos para eliminar perfiles", 403);



    }

    public function search(SearchProfileRequest $request)
    {
        return Role::where($request->searchFields)->get();
    }

    public function permissionsGroups()
    {
        return new PermissionGroupsCollection( PermissionGroup::with('permissions')->get() );
    }

    public function updatePermissions($roleId, UpdatePermissionsRequest $request)
    {
        if( null == $role = Role::find($roleId) ) {
            return response()->json('No se ha encontrado el rol', 404);
        }

        $role->syncPermissions($request->permissions);

        return response()->json('Permisos actualizados con éxito', 200);
    }

}
