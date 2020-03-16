<?php

namespace FourPaws\Innertools\Tools\WebForms;

use Bitrix\Main\Loader;

class WebForm
{
    public static function getBySid(string $sid)
    {
        Loader::includeModule('form');

        $isFiltered = true;
        $arFilter = ['SID' => $sid, 'SID_EXACT_MATCH' => 'Y',];
        $rsForms = \CForm::GetList($by='s_id', $order='desc', $arFilter, $isFiltered);

        return $rsForms->Fetch();
    }

    public static function getIdBySid(string $sid)
    {
        return self::getBySid($sid)['ID'];
    }

    /**
     * Применяется в шаблоне веб-формы для добавления html-атрибутов к полю формы
     *
     * @param $sid
     * @param $arResult
     * @param $params
     * @return string
     */
    public static function addFieldParams($sid, $arResult, $params) {
        $paramsStr = '';
        foreach ($params as $key => $param) {
            $paramsStr .= ' '.$key.'="'.$param.'"';
        }

        if ($arResult['arQuestions'][$sid]['REQUIRED'] == 'Y') {
            $paramsStr .= ' required=""';
        }

        return $paramsStr;
    }
}