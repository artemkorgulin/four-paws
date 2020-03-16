<?php

namespace FourPaws\Innertools\Tools\WebForms;


class WebFormField
{
    public static function GetPhoneField($name, $value = '', $param = '')
    {
        $value = htmlspecialcharsbx($value);
        return '<input type="tel" name="form_text_'.$name.'" value="'.$value.'" '.$param.' />';
    }
}