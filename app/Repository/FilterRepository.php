<?php
namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use App\Repository\Contract\FilterRepositoryInterface;
abstract class FilterRepository implements FilterRepositoryInterface
{
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;   
    }

    public function selectFilter($fields)
    {
        $this->model = $this->model->selectRaw($fields);
    }

    public function selectCondition($conditions)
    {
        $conditions = explode(';',$conditions);
            
        foreach($conditions as $c){
            $cond = explode(':', $c);
            $data = $this->model->where($cond[0],$cond[1], $cond[2]);
        }

        $this->model = $data;
    }

    public function results(){
        return $this->model;
    }
}