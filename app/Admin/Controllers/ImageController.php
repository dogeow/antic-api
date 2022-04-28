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
            $show->field('path_name');
            $show->field('original_name');
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
            $form->image('path_name');
            $form->text('original_name');
            $form->text('imageable_id');
            $form->text('imageable_type');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }

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
            $grid->column('path_name')->image();
            $grid->column('original_name');
            $grid->column('imageable_id');
            $grid->column('imageable_type');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->between('created_at')->datetime();
            });
        });
    }
}
