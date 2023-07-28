<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use App\Console\Commands\GenerateTable;

class lbaseGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $signature = 'lbase:generate';

    protected $signature = 'lbase:generate { name : Class (singular) for example User}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Larabase Genedated Simple CRUD';
    protected $generateTable ;
    protected $seederTable;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->generateTable = new GenerateTable($this);
        $this->seederTable = new SeederTable($this);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');

        $migration = $this->generateTable->generateMigration($name);

        $this->generateModel($name, $migration);
        $this->generateView($name, $migration);
        $this->generateController($name);
        $this->generateService($name);
        $this->generateRepository($name);
        $this->addHeaderRoutes($name);
        $this->addBodyRoutes($name);

        $this->seederTable->seederMenu($name, $migration);



//
//        $this->output->progressStart(5);
//
//        for ($i = 0; $i < 5; $i++) {
//            sleep(1);
//
//            $this->output->progressAdvance();
//        }
//
//
//        $this->output->progressFinish();
//        $this->info("Creating Module $name Success");
    }

    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }

    protected function generateController($name)
    {
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}',
                '{{modelNameSingular}}'
            ],
            [
                $name,
                strtolower(Str::plural($name)),
                strtolower($name)
            ],
            $this->getStub('Controller')
        );

        $dir = app_path("Http/Controllers/Generator");
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents(app_path("Http/Controllers/Generator/{$name}Controller.php"), $controllerTemplate);
        $this->info("New Controller File : ".app_path("Http/Controllers/Generator/{$name}Controller.php"));
    }

    protected function generateModel($name, $column = false)
    {

        if ($column)
        {
            $strColumn = '';
            foreach ($column as $key => $val) {
                $strColumn .= "'$key', \n        ";
            }
            $modelTemplate = str_replace(
                [
                    '{{modelName}}', '{{modelNamePlural}}', '{{modelNameSingular}}', '{{column}}'
                ],
                [
                    $name, strtolower(Str::plural($name)), strtolower($name), $strColumn
                ],
                $this->getStub('Model')
            );
        }else{
            $modelTemplate = str_replace(
                [
                    '{{modelName}}', '{{modelNamePlural}}', '{{modelNameSingular}}', '{{column}}'
                ],
                [
                    $name, strtolower(Str::plural($name)), strtolower($name), ''
                ],
                $this->getStub('Model')
            );
        }
        $dir = app_path("Models/Generator/");

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        file_put_contents(app_path("Models/Generator/${name}.php"), $modelTemplate);
        $this->info("New Model File : ".app_path("/Models/Generator/${name}.php"));
    }

    protected function generateView($name, $column = false)
    {
        $strTable = '';
        $strTableAjax = '';
        $strTableModal = '';
        $strTableRules = '';
        $strTableForm = '';

        if ($column){

            foreach ($column as $key => $val) {
                $strTable .= "<th>".ucfirst($key)."</th>\n                                           ";
                $strTableAjax .= "{data: '".$key."', name: '".$key."'},\n                    ";
                $strTableModal .= "$('#".$key."').val(response.".$key.")\n                    ";
                $strTableRules .= "$key: {
                        required: true,
                    },\n                    ";

                $strTableForm .= " <div class='mb-3'>
                        <label class='form-label' for='$key'>".ucwords($key)."</label>
                        <input type='text' id='$key' name='$key' class='form-control' placeholder='".ucfirst($key)."'>
                    </div>";
                /*$strTableForm .= "<fieldset class='form-group floating-label-form-group'>
                    <label for='$key'>".ucwords($key)."</label>
                    <div class='controls'>
                        <input type='text' class='form-control' id='$key' name='$key'
                               placeholder='".ucfirst($key)."' required
                               data-validation-required-message='This field is required'>
                    </div>
                </fieldset>\n                 ";*/
            }

            $viewsTemplate = str_replace(
                [
                    '{{modelName}}',
                    '{{modelNamePlural}}',
                    '{{modelNameSingular}}',
                    '{{strTable}}',
                    '{{strTableAjax}}',
                    '{{strTableModal}}',
                    '{{strTableRules}}',
                    '{{strTableForm}}'
                ],
                [
                    $name,

                    strtolower(Str::plural($name)),
                    strtolower($name),
                    $strTable,
                    $strTableAjax,
                    $strTableModal,
                    $strTableRules,
                    $strTableForm
                ],

                $this->getStub('Views')
            );
        }else{
            $viewsTemplate = str_replace(
                [
                    '{{modelName}}',
                    '{{modelNamePlural}}',
                    '{{modelNameSingular}}'
                ],
                [
                    $name,

                    strtolower(Str::plural($name)),
                    strtolower($name)
                ],

                $this->getStub('Views')
            );
        }


        $dir = base_path("resources/views/admin/contents/" . strtolower($name));

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
//        $viewName = strtolower($name).'.blade.php';
        $viewName = 'index.blade.php';

        file_put_contents("$dir/$viewName", $viewsTemplate);

        $this->generateViewModal($name, $strTableForm);
        $this->info("New View File : $dir/$viewName");

    }

    protected function generateViewModal($name, $strTableForm)
    {

        $modalsTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}',
                '{{modelNameSingular}}',
                '{{strTableForm}}'
            ],
            [
                $name,

                strtolower(Str::plural($name)),
                strtolower($name),
                $strTableForm

            ],

            $this->getStub('Views_Modal')
        );

        $dir = base_path("resources/views/admin/contents/" . strtolower($name));

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
//        $modalsName = "_modal_".strtolower($name).'.blade.php';
        $modalsName = "_modal.blade.php";

        file_put_contents("$dir/$modalsName", $modalsTemplate);

    }

    protected function generateService($name)
    {
        $serviceTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}',
                '{{modelNameSingular}}'
            ],
            [
                $name,

                strtolower(Str::plural($name)),
                strtolower($name)
            ],
            $this->getStub('Service')
        );

        $dir = app_path("Service/Generator");

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents(app_path("Service/Generator/{$name}Service.php"), $serviceTemplate);
        $this->info("New Service File : ".app_path("Service/Generator/{$name}Service.php"));

    }

    protected function generateRepository($name)
    {
        $repositoryTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}',
                '{{modelNameSingular}}'
            ],
            [
                $name,

                strtolower(Str::plural($name)),
                strtolower($name)
            ],
            $this->getStub('Repository')
        );
        $dir = app_path("Models/Repository");

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents(app_path("Repository/Generator/{$name}Repository.php"), $repositoryTemplate);
        $this->info("New Repository File : ".app_path("Repository/Generator/{$name}Repository.php"));

    }


    protected function addHeaderRoutes($name)
    {
        $strToAppend = "use App\Http\Controllers\Generator\\{$name}Controller;\n";

        $file = fopen(base_path('routes/web.php'), 'r+');

        $insertPos = 0;  // variable for saving //<?php position
        while (!feof($file)) {
            $line = fgets($file);
            if (strpos($line, '<?php') !== false) {
                $insertPos = ftell($file);    // ftell will tell the position where the pointer moved, here is the new line after //Users.
                $newline = $strToAppend;
            } else {
                $newline .= $line;   // append existing data with new data of user
            }
        }

        fseek($file, $insertPos);   // move pointer to the file position where we saved above
        fwrite($file, $newline);

        fclose($file);
    }

    protected function addBodyRoutes($name)
    {
        $strToAppend = "\n
    Route::group(['prefix'=>'" . Str::plural(strtolower($name)) . "'], function () {
        Route::get('/', [{$name}Controller::class, 'index'])->name('dashboard_" . Str::plural(strtolower($name)) . "');
        Route::get('/get', [{$name}Controller::class, 'get'])->name('dashboard_" . Str::plural(strtolower($name)) . "_detail');
        Route::get('/delete', [{$name}Controller::class, 'destroy'])->name('dashboard_" . Str::plural(strtolower($name)) . "_delete');
        Route::post('/', [{$name}Controller::class, 'store'])->name('dashboard_" . Str::plural(strtolower($name)) . "_post');
        Route::get('/datatable.json', [{$name}Controller::class ,'__datatable'])->name('dashboard_" . Str::plural(strtolower($name)) . "_table');
    });";


        $file = fopen(base_path('routes/web.php'), 'r+');
        $newline = '';
        $insertPos = 0;  // variable for saving //file_delete position
        while (!feof($file)) {
            $line = fgets($file);
            if (strpos($line, 'file_delete') !== false) {
                $insertPos = ftell($file);    // ftell will tell the position where the pointer moved, here is the new line after //Users.
                $newline = $strToAppend;
            } else {
                $newline .= $line;   // append existing data with new data of user
            }
        }

        fseek($file, $insertPos);   // move pointer to the file position where we saved above
        fwrite($file, $newline);

        fclose($file);
    }


}
