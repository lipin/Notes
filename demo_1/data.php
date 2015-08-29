<?php
$prize_arr = array( 
    '0' => array('id'=>1,'min'=>1,'max'=>29,'prize'=>'һ�Ƚ�','v'=>1), 
    '1' => array('id'=>2,'min'=>302,'max'=>328,'prize'=>'���Ƚ�','v'=>2), 
    '2' => array('id'=>3,'min'=>242,'max'=>268,'prize'=>'���Ƚ�','v'=>5), 
    '3' => array('id'=>4,'min'=>182,'max'=>208,'prize'=>'�ĵȽ�','v'=>7), 
    '4' => array('id'=>5,'min'=>122,'max'=>148,'prize'=>'��Ƚ�','v'=>10), 
    '5' => array('id'=>6,'min'=>62,'max'=>88,'prize'=>'���Ƚ�','v'=>25), 
    '6' => array('id'=>7,'min'=>array(32,92,152,212,272,332), 
'max'=>array(58,118,178,238,298,358),'prize'=>'�ߵȽ�','v'=>50) 
); 
function getRand($proArr) { 
    $result =""; 
 
    //����������ܸ��ʾ��� 
    $proSum = array_sum($proArr); 
 
    //��������ѭ�� 
    foreach ($proArr as $key => $proCur) { 
        $randNum = mt_rand(1, $proSum); 
        if ($randNum <= $proCur) { 
            $result = $key; 
            break; 
        } else { 
            $proSum -= $proCur; 
        } 
    } 
    unset ($proArr); 
    return $result; 
} 
foreach ($prize_arr as $key => $val) { 
    $arr[$val['id']] = $val['v']; 
} 
 
$rid = getRand($arr); //���ݸ��ʻ�ȡ����id 
$res = $prize_arr[$rid-1]; //�н��� 
 
$min = $res['min']; 
$max = $res['max']; 
if($res['id']==7){ //�ߵȽ� 
    $i = mt_rand(0,5); 
    $result['angle'] = mt_rand($min[$i],$max[$i]); 
}else{ 
    $result['angle'] = mt_rand($min,$max); //�������һ���Ƕ� 
} 
$result['prize'] = iconv('gb2312','utf-8',$res['prize']);
 
echo json_encode($result); 

?>