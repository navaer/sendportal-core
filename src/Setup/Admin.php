<?php

namespace Sendportal\Base\Setup;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Sendportal\Base\Models\User;
use Sendportal\Base\Models\Workspace;

class Admin implements StepInterface
{
    const VIEW = 'sendportal::setup.steps.admin';

    public function check(): bool
    {
        return User::count() > 0;
    }

    public function run(?array $input): bool
    {
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => now(),
            'password' => Hash::make($input['password']),
            'api_token' => Str::random(80)
        ]);

        $workspace = Workspace::create([
            'name' => $input['company'],
            'owner_id' => $user->id,
        ]);

        $user->workspaces()->attach($workspace->id, [
            'role' => Workspace::ROLE_OWNER,
        ]);

        return true;
    }

    public function validate(array $input)
    {
        $validationRules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
            'company' => ['required', 'string']
        ];

        $validator = Validator::make($input, $validationRules);

        return $validator->validate();
    }
}