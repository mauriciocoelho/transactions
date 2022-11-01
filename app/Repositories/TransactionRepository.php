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

    public function getAll()
    {
        $data = $this->model->all();
        return $data;
    }    

    public function created(array $data): Transaction
    {        
        return $this->model::create($data);
    }

    public function getShow($id)
    {
        $data = $this->model::find($id);
        return $data;
    }

    public function updated($id, $data)
    {
        $update = $this->model::find($id);
        $update->update($data);
        return $update;
    }

    
    public function deleted($id)
    {
        $data = $this->model::find($id);
        $data->delete();

        return $data;
    }

}
