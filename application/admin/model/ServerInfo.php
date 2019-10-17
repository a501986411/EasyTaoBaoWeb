<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/19
 * Time: 23:10
 */

namespace app\admin\model;


use org\RouterosInfo;
use think\Model;

class ServerInfo extends Model
{
    protected $autoWriteTimestamp = true;//
    public function initialize()
    {
        parent::initialize();
    }

    /**
     *
     * @access public
     * @param $value
     * @param $data
     * @return mixed
     * @author knight
     */
    protected function getRunTimeAttr($value,$data)
    {
        return RouterosInfo::changeRunTime($value);
    }

    /**
     *
     * @access public
     * @param $value
     * @param $data
     * @return float
     * @author knight
     */
    protected function getMemoryRateAttr($value,$data)
    {
        return round(1-($data['freeMemory']/$data['totalMemory']),2);
    }
    /**
     *
     * @access public
     * @param $value
     * @param $data
     * @return float
     * @author knight
     */
    protected function getTotalHddSpaceAttr($value,$data)
    {
        return round($value/1024/1024,1);
    }

    /**
     *
     * @access public
     * @param $value
     * @param $data
     * @return float
     * @author knight
     */
    protected function getFreeHddSpaceAttr($value,$data)
    {
        return round($value/1024/1024,1);
    }

    /**
     *
     * @access public
     * @param $value
     * @param $data
     * @return bool|string
     * @author knight
     */
    protected function getBuildTimeAttr($value,$data){
        return date('Y-m-d H:i:s',strtotime(RouterosInfo::enDateToCn($value)));
    }
    /**
     *
     * @access public
     * @param $value
     * @param $data
     * @return bool|string
     * @author knight
     */
    protected function getSystemTimeAttr($value,$data){
        return date('Y-m-d H:i:d',strtotime(RouterosInfo::enDateToCn($value)));
    }
}