<?php
/**
 * Raisely Webhooks for Craft CMS 3.x.
 *
 * Handles Raisely's Webhooks in CraftCMS
 *
 * @email dgonzalezad@gmail.com
 * @copyright Copyright (c) 2020 Daniel G Adarve
 */


namespace danieladarve\raiselywebhooks\models;

use craft\base\Model;

/**
 * @author    Daniel G Adarve
 * @package   RaiselyWebhooks
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /** @var string */
    public $signingSecret = '';

    /** @var string */
    public $endpoint = 'raisely-webhooks';

    // Public Methods
    // =========================================================================

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['signingSecret', 'string'],
            ['endpoint', 'string'],
        ];
    }
}
