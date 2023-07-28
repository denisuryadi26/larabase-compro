<?php

/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Service;


use App\Models\Group;
use Yajra\DataTables\DataTables;

class CoreService
{
    protected function privilageBtnDatatable($model, $access)
    {
        if ($model->isNotEmpty()) {
            $modelName = get_class($model[0]);
            $data = Datatables::of($model)->addIndexColumn()
                ->addColumn('action', function ($model) use ($access, $modelName) {
                    $delete_btn = '';
                    $update_btn = '';
                    $view_btn = '';
                    $access_btn = '';
                    $parent_id = null;

                    if ($model->parent) {
                        $parent_id = $model->parent->id;
                    }


                    if ($access->is_viewable == true) {
                        $view_btn = "<button class='btn btn-icon btn-info btn-glow mr-1 mb-1 view'
                                     data-toggle='tooltip' data-placement='top' title='View Data' id='view' data-parent_id='$parent_id' data-id='$model->id' style='margin:3px'>
                                        <i class='tf-icons ti ti-eye'></i>
                                </button>";
                    }

                    if ($access->is_deletable == true) {
                        $model->name = ($model->name ? $model->name : ($model->username ? $model->username : $model->parameter));
                        $delete_btn = "<button class='btn btn-icon btn-danger btn-glow mr-1 mb-1 delete'
                                     data-toggle='tooltip' data-placement='top' title='Delete Data' data-parent_id='$parent_id' id='delete' data-name='$model->name' style='margin:3px' data-id='$model->id'>
                                        <i class='tf-icons ti ti-trash'></i>
                                   </button>";
                    }
                    if ($access->is_editable == true) {
                        $update_btn = "<button class='btn btn-icon btn-warning btn-glow mr-1 mb-1 update'
                                     data-toggle='tooltip' data-placement='top' title='Edit Data' data-name='$model->name' style='margin:3px' data-id='$model->id'>
                                        <i class='tf-icons ti ti-pencil'></i>
                                   </button>";
                    }
                    //group access
                    if (strpos($modelName, 'Group')) {
                        $access_btn = "<button class='btn btn-icon btn-success btn-glow mr-1 mb-1 access'
                                     data-toggle='tooltip' data-placement='top' title='Akses Group' data-name='$model->name' style='margin:3px' data-id='$model->id'>
                                        <i class='tf-icons ti ti-lock'></i>
                                   </button>";
                    }


                    $action = $access_btn . $view_btn . $update_btn . $delete_btn;
                    return $action;
                })
                ->make(true);
            return $data;
        } else {
            return [
                "data" => [],
                "total" => 0,
                "recordsTotal" => 0,
                "recordsFiltered" => 0
            ];
        }
    }

    function random_string($length)
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }
}
