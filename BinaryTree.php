<?php
namespace App\Http\Middleware;

//二叉树的元素结构
class TreeNode{
    /**
    *    比他小的元素
    *   @var  $content any
    */
    public $content;

    /**
    *   @var  $left TreeNode
    */
    public $left;

    /**
    *   比他大的元素
    *   @var  $right TreeNode
    */
    public $right;

    /**
    *   @param  $data any
    */
    public function __construct(&$data = null)
    {
        $this->content = $data;
    }

}

class BinaryTree
{
    /**
    *   @var  $data array
    */
    private $arr;

    /**
    *   @var  $data TreeNode
    */
    private $head;

    /**
    *   @param  $data array
    */
    public function __construct(array $data = [])
    {
        $this->arr = $data;
    }

    /** 
    *   将一个有序的数组转换成平衡二叉树
    */
    public function create():TreeNode{
        //排序一下
        sort($this->arr);
        //找到中间的位置
        $bewteen=intval(sizeof($this->arr)/2);
        //先从 根节点 开始生成
        $this->head=new TreeNode($this->arr[$bewteen]);
        unset($this->arr[$bewteen]);
        self::buildNode(array_slice($this->arr,0,$bewteen));
        self::buildNode(array_slice($this->arr,$bewteen));
        return $this->head;
    }
    /** 
    *   生成子节点
    */
    public function buildNode(array $data){
        if(sizeof($data) <=0){
            return null;
        }
        sort($data);
        $bewteen=intval(sizeof($data)/2);
        if(isset($data[$bewteen])){
            
            //新节点
            $tempNode=new TreeNode($data[$bewteen]);
            //判断是那一边
            $way=$tempNode->content["id"] > $this->head->content["id"] ? "right" : "left";
            $next=&$this->head->{$way};
            //如果是跟节点就直接赋值
            if($next==null){
                $this->head->{$way}=&$tempNode;
            }else{
                while(1){
                    //判断是那一边
                    $nextWat=$tempNode->content["id"] > $next->content["id"] ? "right" : "left";
                    //有空的节点就插入
                    if($next->{$nextWat}==null){
                        $next->{$nextWat}=&$tempNode;
                        break;
                    }
                    //下一个节点
                    $next=&$next->{$nextWat};
                }
            }
            //把数据删除掉
            unset($data[$bewteen]);
            //把数组切割开 每次都找中间的那个位置
            self::buildNode(array_slice($data,0,$bewteen));
            self::buildNode(array_slice($data,$bewteen));
        }
        return null;
    }

    /** 
    *   将数组排序返回对象
    *   @param $key string
    *   @return self object
    */
    public function arraySort(string $key) :object{
        //将二维数组进行排序
        $result=array_column($this->arr,null,$key);
        ksort($result);
        $this->arr=$result;
        return $this;
    }
}
