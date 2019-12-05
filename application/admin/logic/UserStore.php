<?php


namespace app\admin\logic;


class UserStore extends BaseLogic
{
    const IS_FOLLOW_YES = 1;
    const IS_FOLLOW_NO = 2;
    protected $isFollowText = [
        self::IS_FOLLOW_YES => "已关注",
        self::IS_FOLLOW_NO  => "已取消关注"
    ];
    protected $model;
    public function __construct()
    {
        $this->model = new \app\admin\model\UserStore();
    }

    /**
     * 关注逻辑
     * @param int $storeId
     * @param int $uid
     * @return array
     */
    public function follow(int $storeId, int $uid)
    {
        $info = $this->getByStoreIdAndUid($storeId, $uid);
        if(empty($info)){ //不存在 新增
            $ret = $this->model->isUpdate(false)->save(['follow_store_id'=>$storeId, 'uid'=>$uid, 'is_follow'=>self::IS_FOLLOW_YES]);
            if(!$ret){
                return $this->error("关注关系新增失败");
            }
        }else{
            if($info['is_follow'] == self::IS_FOLLOW_NO){
                $ret = $this->model->isUpdate(true)->save(['id'=>$info['id'], 'is_follow'=>self::IS_FOLLOW_YES]);
                if($ret === false){
                    return $this->error("设置已关注失败");
                }
            }
        }
        return $this->success();
    }

    public function cancelFollow()
    {

    }

    public function getByStoreIdAndUid(int $storeId, int $uid)
    {
        $info = $this->model->where(['follow_store_id'=>$storeId, 'uid'=>$uid])->find();
        if($info){
            return $info->toArray();
        }
        return [];
    }

    public function getList($where)
    {
        $total = $this->model->where($where)->count();
        $data = $this->model->where($where)->order($this->order)->limit($this->offset, $this->pageSize)->select();
        $storeIdArr = array_column($data, 'follow_store_id');
        $fStroeLg = new FollowStoreLogic();
        $storeInfo =$fStroeLg->getStoreInfoByStoreIds($storeIdArr);
        $storeInfo = array_column($storeInfo, null, 'id');
        foreach ($data as &$row){
            $row['is_follow_text'] = $this->isFollowText[$row['is_follow']];
            $row['name'] = $storeInfo[$row['follow_store_id']]['name'];
            $row['domain'] = $storeInfo[$row['follow_store_id']]['domain'];
        }
        return $this->getPageList($data,$total);
    }

}