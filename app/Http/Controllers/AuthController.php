<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

/**
 * Controller responsável por gerenciar a autenticação de usuários.
 */
class AuthController extends Controller
{
    /**
     * Construtor da classe AuthController.
     *
     * @param AuthService $service Serviço de autenticação.
     */
    public function __construct(AuthService $service)
    {
        // Chama o construtor da classe pai e injeta o serviço de autenticação.
        parent::__construct($service);
    }

    /**
     * Registra um novo usuário.
     *
     * @param RegisterUserRequest $request Requisição validada para registro de usuário.
     * @return \Illuminate\Http\Response Resposta HTTP com o resultado do registro.
     */
    public function register(RegisterUserRequest $request)
    {
        // Chama o método de registro do serviço de autenticação.
        return $this->service->register($request);
    }

    /**
     * Realiza o login de um usuário.
     *
     * @param LoginUserRequest $request Requisição validada para login de usuário.
     * @return \Illuminate\Http\Response Resposta HTTP com o resultado do login.
     */
    public function login(LoginUserRequest $request)
    {
        // Chama o método de login do serviço de autenticação.
        return $this->service->login($request);
    }

    /**
     * Realiza o logout de um usuário.
     *
     * @param Request $request Requisição HTTP para logout.
     * @return \Illuminate\Http\Response Resposta HTTP com o resultado do logout.
     */
    public function logout(Request $request)
    {
        // Chama o método de logout do serviço de autenticação.
        return $this->service->logout($request);
    }

    /**
     * Altera a senha de um usuário.
     *
     * @param ChangePasswordUserRequest $request Requisição validada para alteração de senha.
     * @return \Illuminate\Http\Response Resposta HTTP com o resultado da alteração de senha.
     */
    public function changePassword(ChangePasswordUserRequest $request)
    {
        // Chama o método de alteração de senha do serviço de autenticação.
        return $this->service->changePassword($request);
    }

    /**
     * Retorna o perfil do usuário autenticado.
     *
     * @return \Illuminate\Http\Response Resposta HTTP com os dados do perfil do usuário.
     */
    public function profile()
    {
        // Chama o método de perfil do serviço de autenticação.
        return $this->service->profile();
    }
}
