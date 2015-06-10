<?php
include_once(MODX_BASE_PATH.'assets/snippets/DLRequest/lib/dlrequest.class.php');
$DLRequest = new DLRequest($modx);
$runSnippet = isset($runSnippet) ? $runSnippet : 'DocLister';


$passParams = $DLRequest->getPassParams();
if ($paramsForm) $modx->setPlaceholder($paramsForm,$DLRequest->buildParamsForm());

return $modx->runSnippet($runSnippet,array_merge($params,$passParams));