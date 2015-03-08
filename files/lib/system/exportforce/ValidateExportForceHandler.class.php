<?php
namespace wcf\system\exportforce;
use wcf\system\WCF;

class ValidateExportForceHanler extends AbstractExportForceHandler implements IExportForceHandler {
    protected $efFilename = 'validate.php';
    protected $efKlammID = 0;
    
    public function setKlammID($klammID) {
        $this->efKlammID = $klammID;
    }
    
    public function execute() {
        if(empty($this->efKlammID)) {
            throw new SystemException('klammID is empty');
        }
        
        $this->setParam(array(
            'k_id' => $this->efKlammID,
        ));
        
        parent::execute();
    }
}