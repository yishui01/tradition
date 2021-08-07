<?php

namespace App\Admin\Controllers;

use App\Models\User;
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
            $grid->column('email');
            //$grid->column('email_verified_at');
//            $grid->column('password');
//            $grid->column('remember_token');
            $grid->column('phone');
            $grid->column('avatar')->image('', 50, 50);
            $grid->column('introduction');
            $grid->column('click');
//            $grid->column('wx_openid');
//            $grid->column('wx_pc_openid');
//            $grid->column('wx_union_id');
//            $grid->column('wx_info');
            $grid->column('last_actived_at');
            $grid->column('fans_count');
            $grid->column('follow_count');
            $grid->column('notification_count');
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
            $show->field('email');
            $show->field('email_verified_at');
            $show->field('password');
            $show->field('remember_token');
            $show->field('phone');
            $show->field('avatar');
            $show->field('introduction');
            $show->field('click');
            $show->field('wx_openid');
            $show->field('wx_pc_openid');
            $show->field('wx_union_id');
            $show->field('wx_info');
            $show->field('last_actived_at');
            $show->field('fans_count');
            $show->field('follow_count');
            $show->field('notification_count');
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
            $form->text('email');
            $form->text('email_verified_at');
            $form->text('password');
            $form->text('remember_token');
            $form->text('phone');
            $form->image('avatar');
            $form->text('introduction');
            $form->text('click');
            $form->text('wx_openid');
            $form->text('wx_pc_openid');
            $form->text('wx_union_id');
            $form->text('wx_info');
            $form->text('last_actived_at');
            $form->text('fans_count');
            $form->text('follow_count');
            $form->text('notification_count');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
