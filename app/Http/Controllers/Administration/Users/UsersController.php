<?php

namespace App\Http\Controllers\Administration\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administration\Users\CreateUserRequest;
use App\Http\Requests\Administration\Users\UpdateUserRequest;
use App\Http\Resources\Administration\Users\UserCollection;
use App\Http\Resources\Administration\Users\UserResource;
use App\User;
use Illuminate\Http\Request;

/**
 * @authenticated
 *
 * APIs for managing users
 */
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('roles')->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        //$user->syncRoles($request->roles);
        return response()->json('Usuario creado con éxito.', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserResource(User::with(['roles'])->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @urlParam  id required The ID of the user.
     * @bodyParam name required The name of the user.
     * @bodyParam username required The username wich the user will use to login. Must be UNIQUE in the database.
     * @bodyParam profile_image_url The url of the image wich will be used as profile image.
     * @bodyParam email The email of the user. Must be UNIQUE in the database.
     * @bodyParam password The password for the user.
     *
     * @response 404 {
     *  "message": "Usuario no encontrado."
     * }
     *
     *  @response 200 {
     *      "message": "Usuario actualizado con éxito"
     * }
     */
    public function update(UpdateUserRequest $request, $id)
    {
        if(null == $user = User::find($id)) {
            return response()->json('Usuario no encontrado.', 404);
        }

        $data = $request->all();

        $data['password'] = bcrypt($data['password']);

        $user->update($data);

        //$user->syncRoles($request->roles);

        return response()->json("Usuario actualizado con éxito.", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(null == $user = User::find($id)) {
            return response()->json('Usuario no encontrado.', 404);
        }

        $user->delete();

        return response()->json("Usuario eliminado con éxito.", 200);
    }
}
