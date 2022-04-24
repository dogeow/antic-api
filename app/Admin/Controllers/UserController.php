<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class UserController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('phone_number');
            $grid->column('email');
            $grid->column('email_verified_at');
            $grid->column('github_name');
            $grid->column('remember_token');
            $grid->column('rate_limit');
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
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new User(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('phone_number');
            $show->field('email');
            $show->field('email_verified_at');
            $show->field('github_name');
            $show->field('password');
            $show->field('remember_token');
            $show->field('rate_limit');
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
        return Form::make(new User(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('phone_number');
            $form->text('email');
            $form->text('email_verified_at');
            $form->text('github_name');
            $form->text('remember_token');
            $form->text('rate_limit');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
