<?php
	$debugMode = 1;
	$host_name = "//".$_SERVER['HTTP_HOST']."/";
	if($debugMode == 1)
	{
		ini_set('display_startup_errors', 1);
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
	}

    $emailList = array(
        array("id"=>1,"to"=>"tobaccocontrol@dh.gov.hk", "subject"=>"投訴違例吸煙","template"=>"1.txt")
    );
    $addressList = array(
        array("id"=>1,"name"=>"油金", "address"=>"油麻地彌敦道557-559號永旺行地下及地庫A舖"),
        array("id"=>2,"name"=>"金雞", "address"=>"旺角洗衣街39-55號金雞廣場二樓"),
        array("id"=>3,"name"=>"旺角新之", "address"=>"旺角彌敦道688號新之城廣場地下舖全層"),
        array("id"=>3,"name"=>"觀塘金沙", "address"=>"觀塘道410號地庫")
    );
    $titleList = array(
        array("id"=>1,"name"=>"先生"),
        array("id"=>2,"name"=>"小姐"),
        array("id"=>3,"name"=>"女仕"),
    );

    function searchListWithId($id, $array) {
        foreach ($array as $key => $val) {
            if ($val['id'] === $id) {
                return $key;
            }
        }
        return null;
    }

?>