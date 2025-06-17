<?php

namespace app\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;

class AuthItem extends \mdm\admin\models\searchs\AuthItem
{
    public function search($params, $type)
    {
        $authManager = Yii::$app->authManager;
        $items = $type == Item::TYPE_ROLE ? $authManager->getRoles() : $authManager->getPermissions();

        $this->load($params);
        if ($this->validate()) {
            // ✅ FIX INI WAJIB
            $search = mb_strtolower(trim((string)$this->name));
            $desc = mb_strtolower(trim((string)$this->description));
            $ruleName = $this->ruleName;

            foreach ($items as $name => $item) {
                $f = (empty($search) || mb_strpos(mb_strtolower($item->name), $search) !== false) &&
                     (empty($desc) || mb_strpos(mb_strtolower($item->description), $desc) !== false) &&
                     (empty($ruleName) || $item->ruleName == $ruleName);

                if (!$f) {
                    unset($items[$name]);
                }
            }
        }

        return new ArrayDataProvider([
            'allModels' => array_values($items),
            'sort' => [
                'attributes' => ['name', 'description', 'ruleName'],
            ],
        ]);
    }
}

