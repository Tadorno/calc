<?php

namespace app\components;

use yii\grid\ActionColumn;
use \app\util\MessageUtil;
use \app\util\EncrypterUtil;
use yii\helpers\Url;

class CustomActionColumn extends ActionColumn
{
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye-open');
        $this->initDefaultButton('update', 'pencil');
        $this->initDefaultButton('delete', 'trash', [
            'data-confirm' => MessageUtil::getMessage("MSGA1"),
            'data-method' => 'post',
        ]);
    }

    public function createUrl($action, $model, $key, $index)
    {
        if (is_callable($this->urlCreator)) {
            return call_user_func($this->urlCreator, $action, $model, $key, $index, $this);
        }

        $params = is_array($key) ? $key : ['id' => (string) EncrypterUtil::encrypt($key)];
        $params[0] = $this->controller ? $this->controller . '/' . $action : $action;
        return Url::toRoute($params);
    }
}