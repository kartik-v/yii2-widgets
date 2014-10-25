<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 3.2.0
 */

namespace kartik\widgets;

use Yii;

/**
 * Asset bundle for StarRating Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class StarRatingAsset extends AssetBundle
{

    public function init()
    {
        $this->setSourcePath('@vendor/kartik-v/bootstrap-star-rating');
        $this->setupAssets('css', ['css/star-rating']);
        $this->setupAssets('js', ['js/star-rating']);
        parent::init();
    }
}
