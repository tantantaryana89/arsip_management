<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        echo "⏳ Menghapus semua RBAC...\n";
        $auth->removeAll();

        echo "✅ Menambahkan permissions...\n";

        // --- Permissions: Arsip ---
        $arsipView = $auth->createPermission('arsipView');
        $arsipView->description = 'Melihat arsip';
        $auth->add($arsipView);

        $arsipCreate = $auth->createPermission('arsipCreate');
        $arsipCreate->description = 'Membuat arsip';
        $auth->add($arsipCreate);

        $arsipUpdate = $auth->createPermission('arsipUpdate');
        $arsipUpdate->description = 'Mengubah arsip';
        $auth->add($arsipUpdate);

        $arsipDelete = $auth->createPermission('arsipDelete');
        $arsipDelete->description = 'Menghapus arsip';
        $auth->add($arsipDelete);

        // --- Permissions: Folder ---
        $folderView = $auth->createPermission('folderView');
        $folderView->description = 'Melihat folder';
        $auth->add($folderView);

        $folderCreate = $auth->createPermission('folderCreate');
        $folderCreate->description = 'Membuat folder';
        $auth->add($folderCreate);

        $folderUpdate = $auth->createPermission('folderUpdate');
        $folderUpdate->description = 'Mengubah folder';
        $auth->add($folderUpdate);

        $folderDelete = $auth->createPermission('folderDelete');
        $folderDelete->description = 'Menghapus folder';
        $auth->add($folderDelete);

        // --- Permissions: Peminjaman Arsip ---
        $peminjamanView = $auth->createPermission('peminjamanView');
        $peminjamanView->description = 'Melihat data peminjaman';
        $auth->add($peminjamanView);

        $peminjamanManage = $auth->createPermission('peminjamanManage');
        $peminjamanManage->description = 'Kelola peminjaman';
        $auth->add($peminjamanManage);

        // --- Permissions: User Management ---
        $userView = $auth->createPermission('userView');
        $userView->description = 'Melihat data user';
        $auth->add($userView);

        $userCreate = $auth->createPermission('userCreate');
        $userCreate->description = 'Membuat user';
        $auth->add($userCreate);

        $userUpdate = $auth->createPermission('userUpdate');
        $userUpdate->description = 'Mengubah user';
        $auth->add($userUpdate);

        $userDelete = $auth->createPermission('userDelete');
        $userDelete->description = 'Menghapus user';
        $auth->add($userDelete);

        echo "✅ Menambahkan role user...\n";
        $user = $auth->createRole('user');
        $auth->add($user);

        // Role `user` hanya bisa melihat arsip, folder, dan peminjaman
        $auth->addChild($user, $arsipView);
        $auth->addChild($user, $folderView);
        $auth->addChild($user, $peminjamanView);
        $auth->addChild($user, $userView); // opsional: agar bisa lihat profil sendiri

        echo "✅ Menambahkan role admin...\n";
        $admin = $auth->createRole('admin');
        $auth->add($admin);

        // Admin memiliki semua hak akses
        $auth->addChild($admin, $arsipView);
        $auth->addChild($admin, $arsipCreate);
        $auth->addChild($admin, $arsipUpdate);
        $auth->addChild($admin, $arsipDelete);

        $auth->addChild($admin, $folderView);
        $auth->addChild($admin, $folderCreate);
        $auth->addChild($admin, $folderUpdate);
        $auth->addChild($admin, $folderDelete);

        $auth->addChild($admin, $peminjamanView);
        $auth->addChild($admin, $peminjamanManage);

        $auth->addChild($admin, $userView);
        $auth->addChild($admin, $userCreate);
        $auth->addChild($admin, $userUpdate);
        $auth->addChild($admin, $userDelete);

        // Admin juga mewarisi semua hak dari user
        $auth->addChild($admin, $user);

        echo "✅ Assign role ke user...\n";
        $auth->assign($admin, 1); // User ID 1 = admin
        $auth->assign($user, 3);  // User ID 3 = user biasa

        echo "🎉 RBAC berhasil diinisialisasi.\n";
        return ExitCode::OK;
    }
}
