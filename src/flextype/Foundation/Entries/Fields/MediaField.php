<?php

declare(strict_types=1);

/**
 * Flextype (https://flextype.org)
 * Founded by Sergey Romanenko and maintained by Flextype Community.
 */

use Atomastic\Arrays\Arrays;

if (registry()->get('flextype.settings.entries.fields.media.files.fetch.enabled')) {
     emitter()->addListener('onEntriesFetchSingleHasResult', static function (): void {
         if (entries()->registry()->has('fetch.data.media.files.fetch')) {
             // Get fetch.
             $original = entries()->registry()->get('fetch');
             $data = [];

             switch (registry()->get('flextype.settings.entries.fields.media.files.fetch.result')) {
                 case 'toArray':
                     $resultTo = 'toArray';
                     break;

                 case 'toObject':
                 default:
                     $resultTo = 'copy';
                     break;
             }

             // Modify fetch.
             foreach (entries()->registry()->get('fetch.data.media.files.fetch') as $field => $body) {

                 if (isset($body['options']['method']) &&
                     strpos($body['options']['method'], 'fetch') !== false &&
                     is_callable([flextype('media')->files(), $body['options']['method']])) {
                     $fetchFromCallbackMethod = $body['options']['method'];
                 } else {
                     $fetchFromCallbackMethod = 'fetch';
                 }


                 $result = isset($body['result']) && in_array($body['result'], ['toArray', 'toObject']) ? $body['result'] : $resultTo;

                 $data[$field] = flextype('media')->files()->{$fetchFromCallbackMethod}($body['id'],
                                                            isset($body['options']) ?
                                                                  $body['options'] :
                                                                  []);

                $data[$field] = ($data[$field] instanceof Arrays) ? $data[$field]->{$result}() : $data[$field];
             }

             // Save fetch.
             entries()->registry()->set('fetch.id', $original['id']);
             entries()->registry()->set('fetch.options', $original['options']);
             entries()->registry()->set('fetch.data', arrays($original['data'])->merge($data)->toArray());
         }
     });
}


if (registry()->get('flextype.settings.entries.fields.media.folders.fetch.enabled')) {
     emitter()->addListener('onEntriesFetchSingleHasResult', static function (): void {
         if (entries()->registry()->has('fetch.data.media.folders.fetch')) {

             // Get fetch.
             $original = entries()->registry()->get('fetch');
             $data = [];

             switch (registry()->get('flextype.settings.entries.fields.media.folders.fetch.result')) {
                 case 'toArray':
                     $resultTo = 'toArray';
                     break;

                 case 'toObject':
                 default:
                     $resultTo = 'copy';
                     break;
             }

             // Modify fetch.
             foreach (entries()->registry()->get('fetch.data.media.folders.fetch') as $field => $body) {

                 if (isset($body['options']['method']) &&
                     strpos($body['options']['method'], 'fetch') !== false &&
                     is_callable([flextype('media')->folders(), $body['options']['method']])) {
                     $fetchFromCallbackMethod = $body['options']['method'];
                 } else {
                     $fetchFromCallbackMethod = 'fetch';
                 }


                 $result = isset($body['result']) && in_array($body['result'], ['toArray', 'toObject']) ? $body['result'] : $resultTo;

                 $data[$field] = flextype('media')->folders()->{$fetchFromCallbackMethod}($body['id'],
                                                            isset($body['options']) ?
                                                                  $body['options'] :
                                                                  []);

                $data[$field] = ($data[$field] instanceof Arrays) ? $data[$field]->{$result}() : $data[$field];
             }

             // Save fetch.
             entries()->registry()->set('fetch.id', $original['id']);
             entries()->registry()->set('fetch.options', $original['options']);
             entries()->registry()->set('fetch.data', arrays($original['data'])->merge($data)->toArray());
         }
     });
}
