<?php
namespace AppBundle\Datafixtures\Faker;

// on crée un provider générique de maniere a avoir des fixtures cohérente au projets

class CsProvider extends \Faker\Provider\Base
{
  protected static $profile = [
    'Equ',
    'PL',
    'CA',
    'CAPL',
    'CATE',
    'CATEPL'

  ];
  protected static $typeOf = [
      'Semaine',
      'WE-nuit',
      'WE-jour',
  ];
  public static function profile()
{
    return static::randomElement(static::$profile);
}
  public static function typeOf()
{
    return static::randomElement(static::$typeOf);
}
}
