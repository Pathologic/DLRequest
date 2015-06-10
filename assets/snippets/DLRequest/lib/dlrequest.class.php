<?php namespace DLRequest;
include_once (MODX_BASE_PATH.'assets/snippets/DocLister/lib/jsonHelper.class.php');
include_once (MODX_BASE_PATH.'assets/snippets/DocLister/lib/DLTemplate.class.php');

class DLRequest {
    protected $modx = null;
    public $params = array();
    public $rqParams = array();
    public function __construct($modx) {
        $this->modx = $modx;
        $this->params = $modx->event->params;
        $this->rqParams = \jsonHelper::jsonDecode($this->params['rqParams'], array('assoc' => true), true);
    }

    public function getPassParams() {
        $passParams = array();
        
        if (!empty($this->rqParams)) {
            foreach ($_REQUEST as $key => $value) {
            if (isset($this->rqParams[$key]) && array_key_exists($value,$this->rqParams[$key]) && is_scalar($value) && !empty($value))
                $passParams[$key] = $value;
            }
        }
        return $passParams;
    }

    public function buildParamsForm() {
        $DLTemplate = \DLTemplate::getInstance($this->modx);
        $out = '';
        $rqParamsNames = \jsonHelper::jsonDecode($this->params['rqParamsNames'], array('assoc' => true), true);
        if (!empty($this->rqParams)) {
            $groups = '';
            foreach ($this->rqParams as $paramName => $paramValues) {
                $values = '';
                foreach ($paramValues as $value => $description) {
                    $tpl = $paramName.'.tpl';
                    $tpl = isset($this->params[$tpl]) ? $this->params[$tpl] : $this->params['param.tpl'];
                    $selectedClass = "";
                    if (isset($_REQUEST[$paramName]) && is_scalar($_REQUEST[$paramName]) && $_REQUEST[$paramName]==$value) {
                        $selectedClass = isset($this->params['selectedClassName']) ? $this->params['selectedClassName'] : 'selected';
                    } 
                    $tplPh = array(
                        "value"=>$value,
                        "description"=>$description,
                        "selectedClass"=>$selectedClass
                    );
                    $values .= $DLTemplate->parseChunk($tpl,$tplPh);
                }
                $owner = $paramName.'.ownerTPL';
                $owner = isset($this->params[$owner]) ? $this->params[$owner] : $this->params['param.ownerTPL'];
                
                $tplPh = array(
                    "paramName" => $paramName,
                    "values"=>$values,
                    "description"=>$rqParamsNames[$paramName]
                );
                $groups .= $DLTemplate->parseChunk($owner,$tplPh);
            }
            $keepParams = isset($this->params['keepTpl']) ? $this->getKeepParams() : "";
            $tplPh = array(
                "params"=>$groups,
                "keepParams"=>$keepParams
            );
            $out = $DLTemplate->parseChunk($this->params['paramsOwnerTPL'],$tplPh);
        }
        return $out;
    }

    public function getKeepParams() {
        $DLTemplate = \DLTemplate::getInstance($this->modx);
        $_keepParams = isset($this->params['keepParams']) ? explode(',',$this->params['keepParams']) : array();
        $out = "";
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, $_keepParams)) {
                if (!is_array($_REQUEST[$key])) {
                    $tplPh = array(
                        "paramName" => $key,
                        "value"=>$value
                    );
                    $out .= $DLTemplate->parseChunk($this->params['keepTpl'],$tplPh);
                } else {
                    foreach ($_REQUEST[$key] as $arrValue) {
                        $tplPh = array(
                            "paramName" => $key.'[]',
                            "value"=>$arrValue
                        );
                        $out .= $DLTemplate->parseChunk($this->params['keepTpl'],$tplPh);
                    }
                }
            }
        }
        return $out;
    }
}