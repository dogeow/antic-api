<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Image;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Show;

class ImageController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Image(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('user_id');
            $grid->column('original_name');
            $grid->column('name');
            $grid->column('folder')->display(function ($folder) {
                return $folder.'/'.$this->name;
            })->image();
            $grid->column('imageable_id');
            $grid->column('imageable_type');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param  mixed  $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Image(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('original_name');
            $show->field('name');
            $show->field('folder');
            $show->field('imageable_id');
            $show->field('imageable_type');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Image(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('original_name');
            $form->text('name');
            $form->text('folder');
            $form->text('imageable_id');
            $form->text('imageable_type');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
