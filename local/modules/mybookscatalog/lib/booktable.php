<?php
namespace Bitrix\MyBooksCatalog;

use Bitrix\Main\Entity;
use Bitrix\Main\Type;

class BookTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'my_book';
    }
    
    public static function getUfId()
    {
        return 'MY_BOOK';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\StringField('ISBN', array(
                'required' => true,
                'column_name' => 'ISBNCODE',
                'validation' => function() {
                    return array(
                        new Entity\Validator\Unique(),
                        new Entity\Validator\RegExp('/\d{13}/'),
                        function ($value, $primary, $row, $field) {
                            // проверяем последнюю цифру
                            if ($value[12] > 1) {
                                return true;
                            } else {
                                // если цифра неправильная - возвращаем особую ошибку
                                return new Entity\FieldError(
                                    $field, 'Контрольная цифра ISBN не сошлась', 'MY_ISBN_CHECKSUM'
                                );
                            }
                        }
                    );
                }
            )),
            new Entity\StringField('TITLE'),
            new Entity\DateField('PUBLISH_DATE', array(
                'default_value' => function () {
                    // figure out last friday date
                    $lastFriday = date('Y-m-d', strtotime('last friday'));
                    return new Type\Date($lastFriday, 'Y-m-d');
                }
            )),
            new Entity\TextField('EDITIONS_ISBN', array(
                'serialized' => true
            )),
            new Entity\IntegerField('READERS_COUNT')
        );
    }

    public static function onBeforeAdd(Entity\Event $event)
    {
        $result = new Entity\EventResult;
        $data = $event->getParameter("fields");

        if (isset($data['ISBN']))
        {
            $cleanIsbn = str_replace('-', '', $data['ISBN']);
            $result->modifyFields(array('ISBN' => $cleanIsbn));
        }

        return $result;
    }
}