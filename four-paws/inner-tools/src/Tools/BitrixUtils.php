<?php

namespace FourPaws\Innertools\Tools;

use Bitrix\Main\Grid\Declension;
use Bitrix\Main\Result;
use Bitrix\Main\Type\DateTime;
use DateTimeImmutable;
use DateTimeZone;

class BitrixUtils
{
    const BX_BOOL_FALSE = 'N';

    const BX_BOOL_TRUE = 'Y';

    /**
     * @param float $number
     * @param string $one
     * @param string $two
     * @param string $five
     * @param bool $onlyWord
     *
     * @return string
     *
     * @see Declension
     *
     */
    public static function getCardinalForRus(
        float $number,
        string $one,
        string $two,
        string $five,
        $onlyWord = false
    ) {

        $word = (new Declension($one, $two, $five))->get($number);

        if ($onlyWord) {
            return $word;
        }

        return $number . ' ' . $word;
    }

    /**
     * Определяет является ли запрос аяксовым
     *
     * @return bool
     */
    public static function isAjax()
    {
        //TODO Правильно делать не так, а смотреть на хеадеры `X-Requested-With` === `XMLHttpRequest`

        return ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' || $_SERVER['HTTP_BX_AJAX'] == 'true');
    }

    /**
     * @param bool $value
     *
     * @return string
     */
    public static function bool2BitrixBool(bool $value): string
    {
        return $value ? self::BX_BOOL_TRUE : self::BX_BOOL_FALSE;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public static function bitrixBool2bool(string $value)
    {
        return self::BX_BOOL_TRUE === $value;
    }

    /**
     * Возвращает одно сообщение об ошибке из любого Битриксового результата, где ошибки почему-то живут во
     * множественном числе.
     *
     * @param Result $result
     *
     * @return string
     */
    public static function extractErrorMessage(Result $result): string
    {
        return implode('; ', $result->getErrorMessages());
    }

    /**
     * Конвертирует строку с датой и временем в формате сайта в объект DateTimeImmutable
     *
     * @param string $dateTime
     * @param string|bool $fromSite
     * @param bool $searchInSitesOnly
     * @param DateTimeZone|null $timeZone
     *
     * @return bool|DateTimeImmutable
     */
    public static function bitrixStringDateTime2DateTimeImmutable(
        string $dateTime,
        $fromSite = false,
        bool $searchInSitesOnly = false,
        DateTimeZone $timeZone = null
    ) {
        //TODO Возможно, потребуется исправить сдвиг временной зоны
        $offsetSeconds = 0;

        return DateTimeImmutable::createFromFormat(
            DATE_ISO8601,
            sprintf(
                '%sT%s%+03d%02d',
                ConvertDateTime($dateTime, 'YYYY-MM-DD', $fromSite, $searchInSitesOnly),
                ConvertDateTime($dateTime, 'HH:MI:SS', $fromSite, $searchInSitesOnly),
                floor($offsetSeconds / 3600),
                ($offsetSeconds % 3600) / 60
            ),
            $timeZone
        );
    }

    /**
     * Конвертирует объект DateTimeImmutable в строку в формате сайта
     *
     * @param DateTimeImmutable $dateTimeImmutable
     * @param string $type
     * @param bool $site
     * @param bool $searchInSitesOnly
     *
     * @return string
     */
    public static function dateTimeImmutable2BitrixStringDate(
        DateTimeImmutable $dateTimeImmutable,
        $type = 'SHORT',
        $site = false,
        bool $searchInSitesOnly = false
    ): string {

        //TODO Возможно, потребуется исправить сдвиг временной зоны
        return ConvertTimeStamp(
            $dateTimeImmutable->getTimestamp(),
            $type,
            $site,
            $searchInSitesOnly
        );
    }

    /**
     * Создаёт Битриксовую дату-время из DateTimeImmutable
     *
     * @param DateTimeImmutable $dateTimeImmutable
     *
     * @return DateTime
     */
    public static function createBitrixDateTimeFromDateTimeImmutable(DateTimeImmutable $dateTimeImmutable): DateTime
    {
        return DateTime::createFromPhp(
            \DateTime::createFromFormat(
                DATE_ATOM,
                $dateTimeImmutable->format(DATE_ATOM),
                $dateTimeImmutable->getTimezone()
            )
        );
    }
}
