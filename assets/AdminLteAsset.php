<?php
namespace app\assets;

use yii\web\AssetBundle;

class AdminLteAsset extends AssetBundle
{
    public $basePath = '@webroot/adminlte';
    public $baseUrl = '@web/adminlte';

    public $css = [
        'plugins/fontawesome-free/css/all.min.css',
        'dist/css/adminlte.min.css',
    ];

    public $js = [
        // jQuery disediakan oleh YiiAsset
        'plugins/bootstrap/js/bootstrap.bundle.min.js',
        'dist/js/adminlte.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset', // jQuery
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'yii\grid\GridViewAsset',
    ];
}
