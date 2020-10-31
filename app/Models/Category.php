<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasDateTimeFormatter, ModelTree;
}
