<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

/**
 * Serviço de autenticação responsável por gerenciar o registro, login, logout e outros
 * processos relacionados à autenticação de usuários.
 */
class AuthService extends Service
{
    /**
     * Construtor da classe AuthService.
     *
     * @param UserRepository $repository Repositório de usuários.
     */
    public function __construct(UserRepository $repository)
    {
        // Chama o construtor da classe pai e injeta o repositório de usuários.
        parent::__construct($repository);
    }

    /**
     * Registra um novo usuário.
     *
     * @param Request $request Requisição contendo os dados do usuário.
     * @return \Illuminate\Http\JsonResponse Resposta JSON com os dados do usuário registrado.
     */
    public function register(Request $request)
    {
        // Cria um novo usuário com os dados fornecidos e salva no repositório.
        $user = $this->repository->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['user' => $user], 201);
    }

    /**
     * Realiza o login de um usuário.
     *
     * @param Request $request Requisição contendo os dados de login.
     * @return \Illuminate\Http\JsonResponse Resposta JSON com o token de acesso.
     */
    public function login(Request $request)
    {
        // Obtém o usuário pelo email.
        $user = $this->repository->getOne(['email' => $request->email], 'created_at', 'asc');

        // Verifica se o usuário existe e se a senha está correta.
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Cria um token de acesso para o usuário.
        $token = $user->createToken($user->email)->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    /**
     * Realiza o logout de um usuário.
     *
     * @param Request $request Requisição contendo o token de acesso.
     * @return \Illuminate\Http\JsonResponse Resposta JSON confirmando o logout.
     */
    public function logout(Request $request)
    {
        // Deleta o token de acesso atual do usuário.
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }

    /**
     * Altera a senha de um usuário.
     *
     * @param Request $request Requisição contendo as senhas atual e nova.
     * @return \Illuminate\Http\JsonResponse Resposta JSON confirmando a alteração da senha.
     */
    public function changePassword(Request $request)
    {
        // Verifica se a senha atual está correta.
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return response()->json(['error' => 'Current password is incorrect.'], 400);
        }

        // Atualiza a senha do usuário.
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully.']);
    }

    /**
     * Retorna o perfil do usuário autenticado.
     *
     * @return \Illuminate\Http\JsonResponse Resposta JSON com os dados do perfil do usuário.
     */
    public function profile()
    {
        return response()->json(['user' => Auth::user()], 200);
    }
}
