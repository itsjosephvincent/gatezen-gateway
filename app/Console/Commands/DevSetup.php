<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DevSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download and setup tools for development';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->copyGitHooks();
        $this->downloadPHPCSFixer();

        return Command::SUCCESS;
    }

    public function copyGitHooks(): void
    {
        $this->comment('⚙️ Copying Git Hooks');

        $hooks = File::allFiles(base_path('.git-hooks'));
        foreach ($hooks as $hook) {
            $path = $hook->getPath();
            $filename = $hook->getFilename();
            $target = base_path(".git/hooks/$filename");
            File::copy("$path/$filename", $target);
            chmod($target, 0775);
        }

        $this->info('✔️ Git Hooks copied');
    }

    public function downloadPHPCSFixer(): void
    {
        $this->comment('⚙️ Downloading PHP CS Fixer');

        File::copy('https://cs.symfony.com/download/php-cs-fixer-v3.phar', base_path('php-cs-fixer.phar'));

        $this->info('✔️ PHP CS Fixer downloaded');
    }
}
