<?php
require_once 'aliyuncore/Config.php';


class CommonRpcAcsRequest extends \RpcAcsRequest{
    public $params;

    function  __construct($arr, $tagCode) {

        $actionName=$tagCode==2?$arr->api_second:$arr->api_first;
        parent::__construct($arr->prefix, $arr->version, $actionName);
        $this->setMethod("POST");
        $this->params=$arr;
   }

    public function putQueryParameter($name, $value) {
            $this->queryParameters[$name] = $value;

    }

    public function getNumberAuth($SdkVersion,$PhoneNumber,$tagCode,$accessCode=''){

        $iClientProfile = DefaultProfile::getProfile($this->params['RegionId'], $this->params['accessKeyId'], $this->params['accessSecret']);
        $client= new DefaultAcsClient($iClientProfile);

        $request=new CommonRpcAcsRequest($this->params,$tagCode);
        $request->putQueryParameter("SceneCode", $this->params['SceneCode']);
        $request->putQueryParameter("PhoneNumber", $PhoneNumber);
        if($tagCode==1){
            $request->putQueryParameter("RegionId", $this->params['RegionId']);
            $request->putQueryParameter("SdkVersion", $SdkVersion);
        }
        if($tagCode==2){
            $request->putQueryParameter("AccessCode", $accessCode);
        }

        $result=json_decode($client->getAcsResponse($request),true);
        return $result;
    }


}
