<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace common\behaviors;

use Yii;
use yii\helpers\Inflector;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\validators\UniqueValidator;
use yii\base\InvalidConfigException;
use yii\behaviors\SluggableBehavior;

/**
 * SluggableBehavior automatically fills the specified attribute with a value that can be used a slug in a URL.
 *
 * Note: This behavior relies on php-intl extension for transliteration. If it is not installed it
 * falls back to replacements defined in [[\yii\helpers\Inflector::$transliteration]].
 *
 * To use SluggableBehavior, insert the following code to your ActiveRecord class:
 *
 * ```php
 * use yii\behaviors\SluggableBehavior;
 *
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => SluggableBehavior::class,
 *             'attribute' => 'title',
 *             // 'slugAttribute' => 'slug',
 *         ],
 *     ];
 * }
 * ```
 *
 * By default, SluggableBehavior will fill the `slug` attribute with a value that can be used a slug in a URL
 * when the associated AR object is being validated.
 *
 * Because attribute values will be set automatically by this behavior, they are usually not user input and should therefore
 * not be validated, i.e. the `slug` attribute should not appear in the [[\yii\base\Model::rules()|rules()]] method of the model.
 *
 * If your attribute name is different, you may configure the [[slugAttribute]] property like the following:
 *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => UserHandleBehavior::class,
 *             'slugAttribute' => 'alias',
 *         ],
 *     ];
 * }
 * ```
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 2.0
 */
class UserHandleBehavior extends SluggableBehavior
{

    /**
     * Seperator for Slug
     */
    public $separator = '-';


    /**
     * This method is called by [[getValue]] to generate the slug.
     * You may override it to customize slug generation.
     * The default implementation calls [[\yii\helpers\Inflector::slug()]] on the input strings
     * concatenated by dashes (`-`).
     * @param array $slugParts an array of strings that should be concatenated and converted to generate the slug value.
     * @return string the conversion result.
     */
    protected function generateSlug($slugParts)
    {
        return Inflector::slug(implode($this->separator, $slugParts));
    }

    /**
     * Generates slug using configured callback or increment of iteration.
     * @param string $baseSlug base slug value
     * @param int $iteration iteration number
     * @return string new slug value
     * @throws \yii\base\InvalidConfigException
     */
    protected function generateUniqueSlug($baseSlug, $iteration)
    {
        if (is_callable($this->uniqueSlugGenerator)) {
            return call_user_func($this->uniqueSlugGenerator, $baseSlug, $iteration, $this->owner);
        }

        return $baseSlug . $this->separator . ($iteration + 1);
    }
}
