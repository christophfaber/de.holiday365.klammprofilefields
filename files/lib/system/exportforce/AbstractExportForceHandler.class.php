<?php
namespace wcf\system\exportforce;
use wcf\system\WCF;
use wcf\util\HTTPRequest;
use wcf\util\StringUtil;

abstract class AbstractExportForceHandler implements IExportForceHandler {
    /**
     * The return code if success
     * @var integer
     */
    protected $efReturnCodeSuccess = 1001;
    
    /**
     * URL to the API
     * @var string
     */
    protected $efURL = 'http://www.klamm.de/engine/klamm/';
    
    /**
     * Supported errorcodes
     * @var array
     */
    protected $efErrorCodes = array(
        1002 => 'wcf.exportforce.errorCode1002',
        1003 => 'wcf.exportforce.errorCode1003',
        1004 => 'wcf.exportforce.errorCode1004',
        1016 => 'wcf.exportforce.errorCode1016',
        1097 => 'wcf.exportforce.errorCode1097',
        1098 => 'wcf.exportforce.errorCode1098',
        1099 => 'wcf.exportforce.errorCode1099'
    );
    
    /**
     * Filename for the api
     * @var string
     */
    protected $efFilename = '';
    
    /**
     * Exportforce ID
     * @var unknown
     */
    protected $efID = 0;
    
    /**
     * Exportforce password or apikey
     * @var unknown
     */
    protected $efPassword = '';
    
    /**
     * Addional exportforce parameters
     * @var array
     */
    protected $efAdditionalParam = array();
    
    /**
     * Return code from exportforce
     * @var integer
     */
    protected $efReturnCode = 0;
    
    public function setParam(array $array = array()) {
        $this->efAdditionalParam = $array();
    }
    
    public function execute() {
        if(empty($this->efID) || empty($this->efPassword)) {
            throw new SystemException('exportforce id is not set or exportforce password / apikey is empty');
        }
        
        $request = new HTTPRequest($this->efURL . $this->efFilename, array_merge(array(
            'ef_id' => $this->efID,
            'ef_password' => $this->efPassword
        ), $this->efAdditionalParam));
        $request->execute();
        $reply = $request->getReply();
        $content = $reply['body'];
        
        //split result
        $split = StringUtil::split('|', $content);
        $this->efReturnCode = $split[0];
    }
    
    public function validate() {
        if($this->efReturnCode == $this->efReturnCodeSuccess) return true;
        else return $this->efErrorCodes[$this->efReturnCode];
    }
}