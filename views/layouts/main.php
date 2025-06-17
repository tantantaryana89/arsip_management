<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AdminLteAsset;
use yii\helpers\Html;
use yii\bootstrap4\Breadcrumbs;
use app\widgets\Alert;

AdminLteAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <title>Arsip Managemen</title>
  <?php $this->head() ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php $this->beginBody() ?>

<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <?php if (Yii::$app->user->isGuest): ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['/site/login']) ?>">Login</a>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <?= Html::beginForm(['/site/logout'], 'post') ?>
          <?= Html::submitButton('Logout (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link nav-link']) ?>
          <?= Html::endForm() ?>
        </li>
      <?php endif; ?>
    </ul>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-light elevation-4" style="background-color: #ffffff;">
    <a href="<?= Yii::$app->homeUrl ?>" class="brand-link text-center" style="padding: 0.6rem;">
      <img src="<?= Yii::getAlias('@web/image/logo.png') ?>" alt="Logo"
          class="brand-image" style="height: 40px; object-fit: contain;">
      <span class="brand-text font-weight-bold text-dark d-none d-md-inline"
      style="font-size: 1.5rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
    E-Arsip Assy
</span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          
          <li class="nav-item">
            <a href="<?= Yii::$app->urlManager->createUrl(['/site/index']) ?>" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>Home</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= Yii::$app->urlManager->createUrl(['/folder/index']) ?>" class="nav-link">
              <i class="nav-icon fas fa-folder"></i>
              <p>Archive folder</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= Yii::$app->urlManager->createUrl(['/arsip/index']) ?>" class="nav-link">
              <i class="nav-icon fas fa-archive"></i>
              <p>Manage Archive</p>
            </a>
          </li>

          <!-- Menu Dropdown Peek Arsip -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-eye"></i>
              <p>Archive Request<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= Yii::$app->urlManager->createUrl(['/peminjaman-arsip/index']) ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Peminjaman Arsip</p>
                </a>
                <a href="<?= Yii::$app->urlManager->createUrl(['/rbac-ui/index']) ?>" class="nav-link">
                  <i class="nav-icon fas fa-cog"></i>
                  <p>Assignment</p>
                </a>

              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="<?= Yii::$app->urlManager->createUrl(['/user/index']) ?>" class="nav-link">
              <i class="nav-icon fa fa-users"></i>
              <p>Users</p>
            </a>
          </li>
          
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
          <h1 class="m-0"><?= Html::encode($this->title) ?></h1>
        </div>
        <?php if (!empty($this->params['breadcrumbs'])): ?>
          <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <?= Alert::widget() ?>
        <?= $content ?>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="main-footer text-center">
    <strong>&copy; Assembling <?= date('Y') ?></strong> All rights reserved.
  </footer>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
