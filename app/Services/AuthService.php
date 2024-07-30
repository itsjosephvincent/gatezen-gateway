<?php

namespace App\Services;

use App\Http\Resources\UserAuthenticateResource;
use App\Http\Resources\UserRegisterResource;
use App\Http\Resources\UserResource;
use App\Interface\Repositories\AuditRepositoryInterface;
use App\Interface\Repositories\EntityRepositoryInterface;
use App\Interface\Repositories\PasswordResetRepositoryInterface;
use App\Interface\Repositories\UserRepositoryInterface;
use App\Interface\Services\AuthServiceInterface;
use App\Mail\SendForgotPasswordEmail;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthService implements AuthServiceInterface
{
    private $userRepository;

    private $jwtService;

    private $passwordResetRepository;

    private $entityRepository;

    private $auditRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        JwtService $jwtService,
        PasswordResetRepositoryInterface $passwordResetRepository,
        EntityRepositoryInterface $entityRepository,
        AuditRepositoryInterface $auditRepository
    ) {
        $this->userRepository = $userRepository;
        $this->jwtService = $jwtService;
        $this->passwordResetRepository = $passwordResetRepository;
        $this->entityRepository = $entityRepository;
        $this->auditRepository = $auditRepository;
    }

    public function authenticateUser($payload, $key)
    {
        $jwtData = $this->jwtService->decryptJwt($payload->header('Authorization'), $key);

        $user = $this->userRepository->findUserByEmail($jwtData->email);

        if (isset($user) && $user->is_blocked) {

            $this->auditRepository->store($user, 'Blocked user trying to login.', $payload);

            return response()->json([
                'message' => 'Your account does not have the necessary permissions to perform this action.',
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($user) {
            $token = $user->createToken('auth-token')->plainTextToken;

            $data = [
                'token' => $token,
                'role' => $user->getRoleNames(),
                'user' => new UserResource($user),
            ];

            $this->auditRepository->store($user, 'User successfully logged in.', $payload);

            return new UserRegisterResource($data);
        }

        return response()->json([
            'message' => 'There is no account associated with the email address provided.',
        ], Response::HTTP_BAD_REQUEST);
    }

    public function encryptAuth($payload, $key)
    {
        $jwtData = $this->jwtService->encrypyJwt($payload->email, $key);

        return $jwtData;
    }

    public function gatewayAuth($payload)
    {
        $user = $this->userRepository->findUserByEmail($payload->email);

        if (isset($user) && $user->is_blocked) {

            $this->auditRepository->store($user, 'Blocked user trying to login.', $payload);

            return response()->json([
                'message' => 'Your account does not have the necessary permissions to perform this action.',
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($user) {
            if (! Hash::check($payload->password, $user->password)) {

                $this->auditRepository->store($user, 'User logged in with invalid credentials.', $payload);

                return response()->json([
                    'message' => 'Invalid login credentials.',
                ], Response::HTTP_BAD_REQUEST);
            }

            $token = $user->createToken('auth-token')->plainTextToken;

            $data = [
                'token' => $token,
                'role' => $user->getRoleNames(),
                'user' => new UserResource($user),
            ];

            $this->auditRepository->store($user, 'User successfully logged in.', $payload);

            return new UserAuthenticateResource($data);
        }

        return response()->json([
            'message' => 'There is no account associated with the email address provided.',
        ], Response::HTTP_BAD_REQUEST);
    }

    public function registerUser($payload)
    {
        $user = $this->userRepository->findUserByEmail($payload->email);

        if ($user) {

            $this->auditRepository->store($user, 'User registered with existing email address.', $payload);

            return response()->json([
                'message' => 'Email already exists.',
            ], Response::HTTP_BAD_REQUEST);
        }

        $newUser = $this->userRepository->storeUser($payload);

        $this->entityRepository->store($newUser->name, 1, $newUser);

        $data = [
            'role' => $newUser->getRoleNames(),
            'user' => new UserResource($newUser),
        ];

        $this->auditRepository->store($newUser, 'User successfully registered an account.', $payload);

        return new UserAuthenticateResource($data);
    }

    public function sendForgotPassword($payload)
    {

        $user = $this->userRepository->findUserByEmail($payload->email);

        if (isset($user) && $user->is_blocked) {

            $this->auditRepository->store($user, 'Blocked user trying to reset password.', $payload);

            return response()->json([
                'message' => 'Your account does not have the necessary permissions to perform this action.',
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($user) {
            $token = Str::random(60);
            $this->passwordResetRepository->store($user->email, $token);
            Mail::to($user->email)
                ->send(new SendForgotPasswordEmail($user, $token));

            $this->auditRepository->store($user, 'User successfully request password reset.', $payload);

            return response()->json([
                'message' => 'A forgot password email has been sent to your email address.',
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'There is no account associated with the email address provided.',
        ], Response::HTTP_BAD_REQUEST);
    }

    public function resetPasswordwithToken($payload)
    {
        $passwordReset = $this->passwordResetRepository->findByToken($payload->token);

        if ($passwordReset) {

            $user = $this->userRepository->findUserByEmail($passwordReset->email);

            if (Carbon::now()->diffInSeconds($passwordReset->expires_at, false) <= 0) {

                $this->passwordResetRepository->delete($payload->token);
                $this->auditRepository->store($user, 'User tried to change password with expired token.', $payload);

                return response()->json([
                    'message' => 'The reset password token has already expired.',
                ], Response::HTTP_BAD_REQUEST);
            }

            $updatedUser = $this->userRepository->updatePassword($payload, $user->id);
            $this->passwordResetRepository->delete($payload->token);

            return new UserResource($updatedUser);
        }

        return response()->json([
            'message' => 'Invalid password reset token.',
        ], Response::HTTP_BAD_REQUEST);
    }

    public function changeUserPassword($payload, $user)
    {
        if (! Hash::check($payload->current_password, $user->password)) {

            $this->auditRepository->store($user, 'User tried to change password with invalid current password.', $payload);

            return response()->json([
                'message' => 'Current password entered is invalid.',
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->userRepository->updatePassword($payload, $user->id);

        $this->auditRepository->store($user, 'User successfully changed password.', $payload);

        return new UserResource($user);
    }

    public function logout($user)
    {
        $user->tokens()->delete();

        return true;
    }
}
