<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class GeneratePostmanDocumentation extends Command
{
    protected $signature = 'make:postman';

    protected $description = 'Membuat Dokumentasi API Postman';

    protected $documentationTitle = 'BYP2023 API';

    public function handle()
    {
        $this->info('Membuat Dokumentasi API Postman...');
        $this->info("\n");

        $postman = $this->generateInfo();

        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $value) {
            $controller = explode('@', $value->getActionName())[0];
            $controller = explode('\\', $controller);
            $controller = array_slice($controller, 3);
            $controller = implode('\\', $controller);

            $modelPath = str_replace('Controller', '', $controller);

            $modelPathArr = explode('\\', $modelPath);

            $model = 'App\\Models\\'.$modelPath;
            try {
                $model = new $model;
            } catch (\Throwable) {
                continue;
            }
            $fillable = $model->getFillable();
            $validationRules = $this->manageValidationRules($model->validationRules());

            $modelName = end($modelPathArr);

            $uri = preg_replace('/\{(\w+)\}/', ':$1', $value->uri());

            $method = $value->methods()[0];

            $actionName = explode('@', $value->getActionName())[1];

            // Credits to ChatGPT 3.5 ;)
            $folder = &$postman['item'];
            foreach ($modelPathArr as $key => $value) {
                $folderName = $this->makeModelNamePluralWithSpace($value);

                /*
                    The main purpose of the algorithm is to generate a nested folder structure with items. It does so by iterating over each folder name in the $modelPathArr array, and for each folder name, it generates a new item with a "name" property set to the folder name, and an "item" property set to an empty array.
                */

                $newItem = [
                    'name' => $folderName,
                    'item' => [],
                ];

                /*
                    The algorithm first checks if $folder is null. If it is, that means it's the first folder being added, so it adds the new item to the $folder array, and sets the $folder variable to the "item" property of the new item.
                */

                if ($folder === null) {
                    $folder[] = $newItem;
                    $folder = &$newItem['item'];
                } else {
                    /*
                        If $folder is not null, that means there are already items in the $folder array. The algorithm then checks if there is already a folder with the same name as the current folder being added. It does so by iterating over each item in the $folder array and checking if the "name" property of each item matches the current folder name.
                    */

                    $folderIndex = null;
                    foreach ($folder as $index => $item) {
                        if ($item['name'] === $folderName) {
                            /*
                                If a folder with the same name is found, the algorithm sets the $folder variable to the "item" property of the existing folder with the same name.
                            */

                            $folderIndex = $index;
                            break;
                        }
                    }

                    /*
                        By using references ($folder = &$newItem["item"] and $folder = &$folder[$folderIndex]["item"]), the algorithm is able to modify the original $postman['item'] array directly, rather than creating a copy of the array each time.
                    */

                    if ($folderIndex === null) {
                        $folder[] = $newItem;
                        $folder = &$newItem['item'];
                    } else {
                        $folder = &$folder[$folderIndex]['item'];
                    }
                }
            }

            $item = $this->generateItem(
                $modelName,
                $method,
                $uri,
                $actionName
            );

            if (in_array($method, ['POST', 'PUT'])) {
                switch ($method) {
                    case 'POST':
                        $mode = 'formdata';
                        break;
                    case 'PUT':
                        $mode = 'urlencoded';
                        break;
                }

                $item['request']['body']['mode'] = $mode;
                foreach ($fillable as $key => $value) {
                    $item['request']['body'][$mode][] = [
                        'key' => $value,
                        'value' => '',
                        'type' => 'text',
                        'description' => isset($validationRules[$value]) ? $validationRules[$value] : '',
                    ];
                }
            }

            // Debug
            $this->info($method);
            $this->info($modelPath);
            $this->info($modelName);
            $this->info($uri);
            $this->info(json_encode($validationRules));
            $this->info($actionName);
            $this->info(json_encode($item));
            $this->info("\n");

            // This code below is placing the generated item in the current folder, but it's still not working properly...
            // $folder[] = $item;

            // Instead, we're just adding the item to the root folder
            $postman['item'][] = $item;
        }

        File::put(
            base_path($this->documentationTitle.'.postman_collection.json'),
            json_encode($postman, JSON_PRETTY_PRINT)
        );

        $this->info('Dokumentasi API Postman berhasil dibuat!');
    }

    public function makeModelNamePluralWithSpace($modelName)
    {
        if ($modelName === 'SKKK') {
            return 'SKKK';
        }

        $modelName = Str::plural(preg_replace('/(?<!^)[A-Z]/', ' $0', $modelName));

        return Str::replace('Skkk', 'SKKK', $modelName);
    }

    public function generateInfo()
    {
        return [
            'info' => [
                'name' => $this->documentationTitle,
                'description' => "### _**STILL IN PROGRESS**_\n\nAPI Documentation for **Petra Christian University Student Activity Information System**.\n\nPlease see the [**Entity Relationship Diagram**](https://app.diagrams.net/#G1PKfdvu44mhAaemt4u_q0CEWlvmFooMCj) too.\n\nFinal thesis project by:  \n[**Calvert Tanudihardjo, NRP: C14190033**](https://www.linkedin.com/in/calvert-tanudihardjo/)\n\nIn collaborations with:\n\n- [**Ivan Widiyanto, S.Kom., M.MT**](https://www.linkedin.com/in/ivan-widiyanto/) -- Head of Information Systems Development Center (PPSI)\n- [**Handrian Alandi, NRP: C14190231**](https://www.linkedin.com/in/handrianalandi/)\n    \n\n© MMXXIII – All Glory to God Almighty",
                'schema' => 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json',
            ],
            'item' => [],
        ];
    }

    public function generateItem(
        $name,
        $method,
        $url,
        $actionName,
    ) {
        $name = Str::title(preg_replace('/(?<!^)[A-Z]/', ' $0', $name));
        $name = Str::replace('Skkk', 'SKKK', $name);

        switch ($method) {
            case 'GET':
                if (! in_array($actionName, ['index', 'show', 'store', 'update', 'destroy'])) {
                    $name = preg_replace('/(?<!^)[A-Z]/', ' $0', $actionName);
                    $name = Str::title($name);
                    $name = Str::replace('Id', 'ID', $name);
                    $name = Str::replace('By', 'by', $name);
                    break;
                }

                if (Str::contains(strtolower($url), 'id')) {
                    $name = "Get $name by ID";
                    break;
                }

                $name = Str::plural($name);
                $name = "Get All $name";
                break;
            case 'POST':
                $name = "Create $name";
                break;
            case 'PUT':
                $name = "Update $name";
                break;
            case 'DELETE':
                $name = "Delete $name";
                break;
        }

        return [
            'name' => $name,
            'request' => [
                'auth' => [
                    'type' => 'bearer',
                    'bearer' => [
                        'key' => 'token',
                        'value' => '{{SANCTUM_TOKEN}}',
                        'type' => 'string',
                    ],
                ],
                'method' => $method,
                'header' => [
                    [
                        'key' => 'Accept',
                        'value' => 'application/json',
                    ],
                    [
                        'key' => 'Content-Type',
                        'value' => 'application/json',
                    ],
                ],
                'url' => [
                    'raw' => '{{APP_URL}}/'.$url,
                    'host' => [
                        '{{APP_URL}}',
                    ],
                    'path' => explode('/', $url),
                ],
            ],
            'response' => [],
        ];
    }

    public function manageValidationRules($validationRules)
    {
        $rules = [];

        foreach ($validationRules as $key => $innerRules) {
            foreach ($innerRules as $rule) {
                if (is_string($rule)) {
                    $rules[$key][] = $rule;
                }
            }
            $rules[$key] = implode('|', $rules[$key]);
        }

        return $rules;
    }
}
