<?php

return [
  /*
   * Raisely's  Secret
   */
  'signingSecret' => getenv('RAISELY_SECRET'),

  /*
   * The url of the endpoint you would like to use
   */
  'endpoint' => 'raisely-webhooks',
];
