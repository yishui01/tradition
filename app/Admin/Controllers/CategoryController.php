<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Tree;

class CategoryController extends AdminController
{
    public function index(Content $content)
    {
        return $content->header('树状模型')
            ->body(function (Row $row) {
                $tree = new Tree(new Category);

                $row->column(12, $tree);
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
        return Show::make($id, new Category(), function (Show $show) {
            $show->field('id');
            $show->field('parent_id');
            $show->field('order');
            $show->field('title');
            $show->field('introduction');
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
        return Form::make(new Category(), function (Form $form) {
            $form->display('id');
            $form->select('parent_id')->options(array_merge([0 => '顶级分类'],
                Category::where("parent_id", 0)->pluck("title", "id")->toArray()));
            $form->number('order');
            $form->text('title');
            $form->text('introduction');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
