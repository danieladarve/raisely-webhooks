<?php
/**
 * Raisely Webhooks for Craft CMS 3.x.
 *
 * Handles Raisely's Webhooks in CraftCMS
 *
 * @email dgonzalezad@gmail.com
 * @copyright Copyright (c) 2020 Daniel G Adarve
 */

namespace danieladarve\raiselywebhooks\controllers;

use Craft;
use craft\records\EntryType;
use craft\records\Section;
use craft\web\Controller;
use danieladarve\raiselywebhooks\RaiselyWebhooks;
use craft\elements\Entry;
use yii\web\BadRequestHttpException;

/**
 * @author    Daniel G Adarve
 * @package   RaiselyWebhooks
 * @since     1.0.0
 */
class DefaultController extends Controller
{
  // Protected Properties
  // =========================================================================

  /**
   * @var bool|array
   */
  protected $allowAnonymous = ['index'];

  // Public Methods
  // =========================================================================
  public function __construct($id, $module, $config = [])
  {
    parent::__construct($id, $module, $config = []);
    $this->enableCsrfValidation = false;
  }

  /**
   * @return mixed
   * @throws BadRequestHttpException
   * @throws \Throwable
   */
  public function actionIndex()
  {
    $this->requirePostRequest();
    $eventPayload = json_decode(Craft::$app->getRequest()->getRawBody());
    if (!$this->verifySignature($eventPayload)) {
      return FALSE;
    }

    try {
      return $this->savePoppy($eventPayload->data);
    } catch (\Exception $exception) {
      Craft::error($exception->getMessage(), __METHOD__);
      return FALSE;
    }
  }

  /**
   * @param $payload
   * @return bool
   */
  protected function verifySignature($payload)
  {
    if (!isset($payload->secret)) {
      return FALSE;
    }
    $secret = RaiselyWebhooks::$plugin->getSettings()->signingSecret;
    return $secret === $payload->secret;
  }

  /**
   * @param $eventPayload
   * @return Entry
   * @throws \Throwable
   * @throws \craft\errors\ElementNotFoundException
   * @throws \yii\base\Exception
   */
  protected function savePoppy($eventPayload)
  {
    $entryType = EntryType::find()->where(['handle' => 'poppy'])->one();

    $entry = new Entry();
    $entry->sectionId = $entryType->getAttribute('sectionId');
    $entry->typeId = $entryType->getAttribute('id');
    $entry->fieldLayoutId =$entryType->getAttribute('fieldLayoutId');
    $entry->authorId = 0;

    $entry->enabled = TRUE;
    $entry->title = $eventPayload->data->private->title;
    $entry->setFieldValues([
      'firstName' => $eventPayload->data->firstName,
      'lastName'  => $eventPayload->data->lastName,
      'email'     => $eventPayload->data->email,
      'anonymous' => $eventPayload->data->anonymous,
      'amount'    => $eventPayload->data->amount,
      'message'   => $eventPayload->data->message,
    ]);

    return Craft::$app->elements->saveElement($entry);
  }
}
