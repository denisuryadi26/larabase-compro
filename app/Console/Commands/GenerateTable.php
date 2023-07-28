<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class GenerateTable
{
    protected $command;
    protected $lbase;

    public function __construct($command)
    {
        $this->command = $command;

    }

    function generateMigration($name)
    {
        $arrColumn = [];
        $table = $this->command->choice(
            'Generate Table?',
            ['Yes', 'No']
        );

        if ($table == "Yes")
        {
            $this->command->info("Message : Please Input Column Except Primary Key");
            $numberColumn = $this->command->ask('How Many Column?');
            $this->intValidate($numberColumn);

            if (is_numeric($numberColumn))
            {
               $arrColumn = $this->inputColumn($numberColumn);
               $column = $this->generateColumn($arrColumn);

                $migrationTemplate = str_replace(
                    [
                        '{{modalName}}',
                        '{{column}}',
                        '{{modelNameSingular}}',
                        '{{ClassNameSingular}}'
                    ],
                    [
                        $name,
                        $column,
                        strtolower($name),
                        Str::plural($name)
                    ],

                    file_get_contents(resource_path("stubs/Migration.stub"))

                );
                $filename = date("Y_m_d",time()).'_000000'."_create_".strtolower(Str::plural($name))."_table.php";
                file_put_contents(base_path("database/migrations/$filename"), $migrationTemplate);

                Artisan::call('migrate');
                $this->command->info('Migrate Success');
                $this->command->info("New Migration File : ".base_path("database/migrations/$filename"));
            }else{
                $this->command->info("Error : Please Input Numeric Only");
            }
        }
        return $arrColumn;
    }

    function inputColumn($numberColumn) : array
    {
        $arrResult = [];

        for ($i = 1 ; $i <= $numberColumn; $i++)
        {
           $columnName = $this->command->ask("$i. Column Name?");

           $columnType = $this->command->choice(
                "$i. Type For Column $columnName?",
                ['integer', 'string', 'text', 'date','timestamp', 'uuid']
            );

           $arrResult[$columnName] = $columnType;
        }


        return $arrResult;
    }

    function intValidate($param)
    {
        if (!is_numeric($param))
        {
            $this->command->info("Error : Please Input Numeric Only");
            die;
        }
    }

    function generateColumn(array $data)
    {
        $strMigration = "";
        foreach ($data as $key => $val)
        {
            $strMigration .=
                '$table->'.$val.'("'.$key.'")'.";\r\n                ";
        }
        return $strMigration;

    }

}