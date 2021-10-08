<?php
/*
 * File name: helpers.php
 * Copyright (c) 2021
 */

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use InfyOm\Generator\Common\GeneratorField;
use InfyOm\Generator\Utils\GeneratorFieldsInputUtil;
use InfyOm\Generator\Utils\HTMLFieldGenerator;
use Symfony\Component\ErrorHandler\Error\FatalError;



/**
 * return add type
 * @param $typeId
 * @return
 */
function getAddType($typeId)
{
    echo "<button class='rounded-pill'><span class='px-1'>".  __('translation.required')."</span> </button";
   // die;
    // if (!empty($typeId)) {
    //    echo "<button class='rounded-pill'><span class='px-1'>".  __('translation.required')."</span> </button";

    // } else {
    //     return "<button class='rounded-pill'><span class='px-1'>".  __('translation.required')."</span> </button";
    // }
}
