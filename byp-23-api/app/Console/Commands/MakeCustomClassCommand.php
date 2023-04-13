<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeCustomClassCommand extends Command
{
    protected $signature = 'make:custom-class {classParentDirectory} {className}';

    protected $description = 'Membuat class baru berdasarkan template berdasarkan parameter classParentDirectory dan className';

    public function handle()
    {
        $classParentDirectory = $this->argument('classParentDirectory');
        $classParentDirectory = str_replace('/', '\\', $classParentDirectory);
        $className = $this->argument('className');

        $err = false;

        $this->generateFile(
            'model',
            $err,
            $classParentDirectory,
            $className
        );

        $this->generateFile(
            'controller',
            $err,
            $classParentDirectory,
            $className
        );

        $this->generateFile(
            'service',
            $err,
            $classParentDirectory,
            $className
        );

        $this->generateFile(
            'repository',
            $err,
            $classParentDirectory,
            $className
        );

        $this->generateFile(
            'resource',
            $err,
            $classParentDirectory,
            $className
        );

        $this->generateFile(
            'factory',
            $err,
            $classParentDirectory,
            $className
        );

        $this->generateFile(
            'seeder',
            $err,
            $classParentDirectory,
            $className,
        );

        $this->generateFile(
            'migration',
            $err,
            $classParentDirectory,
            $className,
        );

        $this->generateFile(
            'test',
            $err,
            $classParentDirectory,
            $className
        );

        if (! $err) {
            $this->info("----------------------------------------\nSemua komponen dari {$className} telah berhasil dibuat!");
        }
    }

    public function generateFile(
        $templateFileName,
        &$err,
        $classParentDirectory,
        $className,
    ) {
        $templateFileNameTitleCase = Str::studly($templateFileName);
        $this->info("{$templateFileNameTitleCase} {$className} sedang dibuat...");

        switch ($templateFileName) {
            case 'model':
                $componentPath = 'App/Models';
                break;
            case 'controller':
                $componentPath = 'App/Http/Controllers';
                break;
            case 'service':
                $componentPath = 'App/Services';
                break;
            case 'repository':
                $componentPath = 'App/Repositories';
                break;
            case 'resource':
                $componentPath = 'App/Http/Resources';
                break;
            case 'factory':
                $componentPath = 'database/factories';
                break;
            case 'seeder':
                $componentPath = 'database/seeders';
                break;
            case 'migration':
                $componentPath = 'database/migrations';
                break;
            case 'test':
                $componentPath = 'tests/Unit';
                break;
        }

        $classNameSnakePlural = Str::snake(Str::plural($className));
        $classNameCamelCase = Str::camel($className);
        $classNameCamelCasePlural = Str::camel(Str::plural($className));

        switch ($templateFileName) {
            case 'model':
                $path = "{$componentPath}/{$classParentDirectory}/{$className}.php";
                break;
            case 'migration':
                $fileName = date('Y_m_d_His')."_create_{$classNameSnakePlural}_table";
                $path = "{$componentPath}/{$fileName}.php";
                break;
            default:
                $fileNameSuffix = Str::studly($templateFileNameTitleCase);
                $path = "{$componentPath}/{$classParentDirectory}/{$className}{$fileNameSuffix}.php";
                break;
        }

        if ($templateFileName === 'migration') {
            $migrationFiles = File::glob("{$componentPath}/*_create_{$classNameSnakePlural}_table.php");
            if (count($migrationFiles) > 0) {
                $err = true;
                $this->error("ERROR: [{$migrationFiles[0]}] telah tersedia.");
                $this->info("\n");

                return;
            }
        } elseif (File::exists($path)) {
            $err = true;
            $this->error("ERROR: [$path] telah tersedia.");
            $this->info("\n");

            return;
        }

        $template = File::get(base_path("templates/{$templateFileName}.txt"));
        $content = str_replace(
            [
                '{{ classParentDirectory }}',
                '{{ className }}',
                '{{ classNameSnakePlural }}',
                '{{ classNameCamelCase }}',
                '{{ classNameCamelCasePlural }}',
            ],
            [
                $classParentDirectory,
                $className,
                $classNameSnakePlural,
                $classNameCamelCase,
                $classNameCamelCasePlural,
            ],
            $template
        );

        try {
            File::put($path, $content);
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), 'No such file or directory') !== false) {
                $this->error("ERROR: Direktori /{$componentPath}/{$classParentDirectory} tidak ditemukan.");
                $answer = $this->ask("Apakah Anda ingin membuat direktori {$classParentDirectory} di {$componentPath}? [y/n]");

                if ($answer === 'y') {
                    $this->info("Membuat direktori /{$componentPath}/{$classParentDirectory}...");
                    File::makeDirectory("{$componentPath}/{$classParentDirectory}", 0755, true);

                    $this->info("{$templateFileNameTitleCase} {$className} sedang dibuat...\n");
                    File::put($path, $content);
                } elseif ($answer === 'n') {
                    $err = true;
                } else {
                    $err = true;
                    $this->error('ERROR: Jawaban tidak valid.');
                    $this->info("\n");
                }
            } else {
                $err = true;
                $this->error("ERROR: [{$e->getMessage()}]");
                $this->info("\n");
            }

            return;
        }
    }
}
