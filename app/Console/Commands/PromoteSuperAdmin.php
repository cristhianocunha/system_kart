<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class PromoteSuperAdmin extends Command
{
    protected $signature   = 'user:superadmin {email : E-mail do usuário a promover}';
    protected $description = 'Promove um usuário a super admin (is_admin=true, team_id=null)';

    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();

        if (! $user) {
            $this->error("Usuário com e-mail \"{$this->argument('email')}\" não encontrado.");
            return self::FAILURE;
        }

        $user->update(['is_admin' => true, 'team_id' => null]);

        $this->info("✓ {$user->name} ({$user->email}) é agora super admin.");
        return self::SUCCESS;
    }
}
