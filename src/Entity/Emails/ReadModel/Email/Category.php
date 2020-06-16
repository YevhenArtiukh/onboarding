<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-30
 * Time: 10:14
 */

namespace App\Entity\Emails\ReadModel\Email;

use App\Entity\Emails\Email\Category as EmailCategory;

final class Category
{
    private $category;

    public static $categoriesTranslation = [
        EmailCategory::ADMINISTRATIVE => 'Administracyjne',
        EmailCategory::ONBOARDING => 'Onboarding',
        EmailCategory::DEADLINES_TRAINING => 'Terminy szkoleń'
    ];

    public function __construct(string $category)
    {
        $this->category = $category;
    }

    public static function getCategories()
    {
        return self::$categoriesTranslation;
    }

    public function __toString()
    {
        if(isset(self::$categoriesTranslation[$this->category]))
            return self::$categoriesTranslation[$this->category];

        return $this->getOriginalCategory();
    }

    public function getOriginalCategory(): string
    {
        return $this->category;
    }
}