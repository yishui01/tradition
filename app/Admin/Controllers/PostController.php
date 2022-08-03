<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Post;
use App\Models\Category;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class PostController extends AdminController
{


    public function index(Content $content)
    {
        return $content
            ->header('文章列表')
//            ->body(Callout::make('即将在下个版本发布，敬请期待~'))
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Post(['category', 'user']), function (Grid $grid) {

            $grid->quickSearch(['title', 'content'])->placeholder('标题、内容搜索')->auto(false);
            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->select('category_id', '分类', Category::query()->pluck('title', 'id'));
            });
            $grid->filter(function($filter){
                // 在这里添加字段过滤器
                $filter->equal('title', '标题');
                $filter->between('created_at', '创建时间')->datetime();
                $filter->between('updated_at', '更新时间')->datetime();
                $filter->between('post_date', '发布时间')->datetime();

            });
            $grid->column('id')->sortable();
            //$grid->column('url');
            //$grid->column('author');
            $grid->column('title', '标题');
            $grid->column('excerpt', '摘要');
            $grid->column('author', '作者');
            //$grid->column('content');
            //$grid->column('user_id','用户ID');
            $grid->column('category.title', '所属分类');
            $grid->column('reply_count', '回复数')->sortable();
            $grid->column('view_count', '浏览数')->sortable();
            $grid->column('nice_count', '点赞数')->sortable();
            //$grid->column('last_reply_user_id');
            $grid->column('order', '排序权重')->sortable();
            //$grid->column('slug');
            $grid->column('post_date', '发布时间')->sortable();
            //$grid->column('created_at');
            $grid->column('updated_at', '更新时间')->sortable();

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
            $form->editor('content');
            $form->datetime('post_date');
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
