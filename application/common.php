<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用公共文件
use think\Env;
use think\Route;
// admin子域名绑定到admin模块
Route::domain(Env::get('domain.sub'),'admin');
function enDateToCn($date)
{
    $en = ['January','February','March','April',
        'May','June','July','August','September',
        'October','November','December'];
    $cn = ['01','02','03','04','05','06','07','08','09','10','11','12'];
    $en1 = ['Jan','Feb','Mar','Apr','May','June','July','Aug','Sept','Oct','Nov','Dec'];
    return str_ireplace ($en1,$cn,str_ireplace ($en,$cn,$date));
}
/**
 * 提取二维数组中的某些列作为一个新的数组
 * @access public
 * @param $source 数据源
 * @param array $columns 需要保留的字段
 * @param string $keyColumns 新数组的key 默认为自然苏
 * @return array
 * @author knight
 */
function arrayColumns($source, $columns=[], $keyColumns='')
{
    $result = [];
    foreach ($source as $k => $v) {
        if(is_object($v)){
            $v = json_decode(json_encode($v),true);
        }
        if(!empty($columns)){
            foreach ($v as $k1=>$v1 ) {
                if (in_array($k1, $columns) && !empty($keyColumns)){
                    $result[$v[$keyColumns]][$k1] = $v1;
                }elseif (in_array($k1, $columns) && empty($keyColumns)){
                    $result[$k][$k1] = $v1;
                }
            }
        } else {
            if(!empty($keyColumns)){
                $result[$v[$keyColumns]] = $v;
            } else {
                $result[] =$v;
            }
        }
    }
    return $result;
}
/**
 * 数据调试
 * @param array $data 数据
 * @param string $pattern 输出类型
 * @return void
 */
function debug($data)
{
    if (config('APP_DEBUG')) {
        echo '<pre>' . PHP_EOL;
        echo '[type] ' . gettype($data) . PHP_EOL;
        echo '[data] ';
        print_r($data);
        exit;
    }
}
/**
 * 把二维数组转化为树状结构数组
 *
 * [@since]   2016-12-05
 * [@author] mingazi@163.com
 * [@param]   array    $arr          要处理的数组
 * [@param]   string   $pid          父级ID的值，默认是0
 * @param   string   $idName       id的名称,默认是id
 * @param   string   $pidName      pid的名称,默认是pid
 * @param   string   $childName    下级的key名称，默认是child
 * @return  array    $tree          生成的树状数组
 */
function createTree($arr = array(), $pid = 0, $idName = 'id', $pidName = 'pid', $childName = 'child')
{
    $tree = array();
    foreach($arr as $k => $v)
    {
        if($v[$pidName] == $pid)
        {
            $tmp = $arr[$k];
            unset($arr[$k]);
            $tmp[$childName] = createTree($arr,$v[$idName],$idName,$pidName,$childName);
            $tree[] = $tmp;
        }
    }
    return $tree;
}