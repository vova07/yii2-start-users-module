<?php

namespace vova07\users\controllers\frontend;

use vova07\users\models\frontend\Email;
use vova07\users\Module;
use yii\web\Controller;
use Yii;

/**
 * Default frontend controller.
 */
class DefaultController extends Controller
{
    /**
     * Confirm new e-mail address.
     *
     * @param string $key Confirmation token
     *
     * @return mixed View
     */
    public function actionEmail($key)
    {
        $model = new Email(['token' => $key]);

        if ($model->isValidToken() === false) {
            Yii::$app->session->setFlash(
                'danger',
                Module::t('users', 'FRONTEND_FLASH_FAIL_NEW_EMAIL_CONFIRMATION_WITH_INVALID_KEY')
            );
        } else {
            if ($model->confirm()) {
                Yii::$app->session->setFlash(
                    'success',
                    Module::t('users', 'FRONTEND_FLASH_SUCCESS_NEW_EMAIL_CONFIRMATION')
                );
            } else {
                Yii::$app->session->setFlash(
                    'danger',
                    Module::t('users', 'FRONTEND_FLASH_FAIL_NEW_EMAIL_CONFIRMATION')
                );
            }
        }

        return $this->goHome();
    }
}
