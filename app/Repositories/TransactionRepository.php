<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class TransactionRepository.
 */
class TransactionRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Transaction::class;
    }

    public function list()
    {
        $result = $this->model->all();
        return $result;
    }

    public function created($validatedData)
    {        
        $type = $validatedData['type'];
        $value = $validatedData['value'];

        if($type == 'income'){
            $transaction = new $this->model();
            $transaction->title = $validatedData['title'];        
            $transaction->value = $validatedData['value'];
            $transaction->type  = $validatedData['type'];
            $transaction->save();
        }elseif($type == 'outcome'){
            $total = $this->model
            ->select(DB::raw('SUM(CASE WHEN type = "income" THEN value ELSE 0 END - CASE WHEN type = "outcome" THEN value ELSE 0 END) as total'))->get();
            if ($value >= $total){
                $transaction = new $this->model();
                $transaction->title = $validatedData['title'];        
                $transaction->value = $validatedData['value'];
                $transaction->type  = $validatedData['type'];
                $transaction->save();
            }
        }       

        return $transaction;
    }
    
    public function deleted($id)
    {
        $data = $this->model::find($id);
        $data->delete();

        return $data;
    }

}
