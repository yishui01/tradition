<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Reply;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ReplyController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Reply(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('post_id');
            $grid->column('content');
            $grid->column('parent_id');
            $grid->column('path');
            $grid->column('user_id');
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
        return Show::make($id, new Reply(), function (Show $show) {
            $show->field('id');
            $show->field('post_id');
            $show->field('content');
            $show->field('parent_id');
            $show->field('path');
            $show->field('user_id');
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
        return Form::make(new Reply(), function (Form $form) {
            $form->display('id');
            $form->text('post_id');
            $form->text('content');
            $form->text('parent_id');
            $form->text('path');
            $form->text('user_id');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
