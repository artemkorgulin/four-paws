<?php

namespace FourPaws\Innertools\Tools;

/**
 * Class MiscTools
 * @package Adv\Bitrixtools\Tools
 *
 * Все прочие полезные функции, для которых пока нет отдельного класса.
 */
class MiscUtils
{
    /**
     * Нормализует телефонный номер.
     *
     * Проверяет телефонный номер на достаточность длины. Это быстрая проверка, которая позволяет поймать явно
     * неверный телефонный номер. Его длина должна быть от 11 до 15 цифр и это подходит для России, Казахстана,
     * Армении, Белоруссии.
     *
     * @param string $phone
     *
     * @return string|bool Нормализованный телефон: только цифры или false в случае ошибки
     *
     */
    public static function normalizePhone($phone)
    {
        $phoneNormalized = preg_replace('/[^\d]/', '', trim($phone));

        //Замена 8 XXX XXX XX XX на 7 XXX XXX XX XX - из внутреннего в международный формат для России и Казахстана
        $phoneNormalized = preg_replace("/^8(\d{10})/", "7$1", $phoneNormalized);

        if (strlen($phoneNormalized) < 11 || strlen($phoneNormalized) > 15) {
            return false;
        }

        return $phoneNormalized;
    }

    /**
     * Возвращает имя класса без namespace
     *
     * @param $object
     *
     * @return string
     */
    public static function getClassName($object)
    {
        $className = get_class($object);
        $pos = strrpos($className, '\\');
        if ($pos) {

            return substr($className, $pos + 1);
        }

        return $pos;
    }
}
