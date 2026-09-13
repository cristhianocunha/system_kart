<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'name'      => ['required', 'string', 'max:255'],
            'team_name' => ['required', 'string', 'max:100', 'unique:teams,name'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => $this->passwordRules(),
            'terms'     => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ], [
            'team_name.required' => 'O nome do kartódromo é obrigatório.',
            'team_name.unique'   => 'Já existe um kartódromo com esse nome.',
        ])->validate();

        return DB::transaction(function () use ($input) {
            $slug = Str::slug($input['team_name']);
            $originalSlug = $slug;
            $count = 1;
            while (Team::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            $team = Team::create([
                'name'          => $input['team_name'],
                'slug'          => $slug,
                'trial_ends_at' => now()->addDays(14),
            ]);

            return User::create([
                'name'     => $input['name'],
                'email'    => $input['email'],
                'password' => Hash::make($input['password']),
                'is_admin' => true,
                'team_id'  => $team->id,
            ]);
        });
    }
}
