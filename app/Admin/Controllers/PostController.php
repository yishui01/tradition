<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Post;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class PostController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Post(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('url');
            $grid->column('author');
            $grid->column('title');
            $grid->column('content');
            $grid->column('post_date');
            $grid->column('user_id');
            $grid->column('category_id');
            $grid->column('reply_count');
            $grid->column('view_count');
            $grid->column('nice_count');
            $grid->column('last_reply_user_id');
            $grid->column('order');
            $grid->column('excerpt');
            $grid->column('slug');
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
        return Show::make($id, new Post(), function (Show $show) {
            $show->field('id');
            $show->field('url');
            $show->field('author');
            $show->field('title');
            $show->field('content');
            $show->field('post_date');
            $show->field('user_id');
            $show->field('category_id');
            $show->field('reply_count');
            $show->field('view_count');
            $show->field('nice_count');
            $show->field('last_reply_user_id');
            $show->field('order');
            $show->field('excerpt');
            $show->field('slug');
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
        return Form::make(new Post(), function (Form $form) {
            $form->display('id');
            $form->text('url');
            $form->text('author');
            $form->text('title');
            $form->text('content');
            $form->text('post_date');
            $form->text('user_id');
            $form->text('category_id');
            $form->text('reply_count');
            $form->text('view_count');
            $form->text('nice_count');
            $form->text('last_reply_user_id');
            $form->text('order');
            $form->text('excerpt');
            $form->text('slug');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
