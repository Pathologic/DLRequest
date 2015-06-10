<?php
$controllerClass = isset($DLRController) ? $DLRController : '';
if (empty($controllerClass) || !class_exists($controllerClass)) {
    include_once(MODX_BASE_PATH.'assets/snippets/DLRequest/lib/dlrequest.class.php');
    $controllerClass = '\DLRequest\DLRequest';
}
$DLRequest = new $controllerClass($modx);
if (!$DLRequest instanceof \DLRequest\DLRequest) return;

$runSnippet = isset($runSnippet) ? $runSnippet : 'DocLister';

$passParams = $DLRequest->getPassParams();
if ($paramsForm) $modx->setPlaceholder($paramsForm,$DLRequest->buildParamsForm());

return $modx->runSnippet($runSnippet,array_merge($params,$passParams));