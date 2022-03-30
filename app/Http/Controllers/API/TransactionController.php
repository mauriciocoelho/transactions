<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use App\Repositories\TransactionRepository;
use Exception;

class TransactionController extends Controller
{
    protected $repository;

    public function __construct(
        TransactionRepository $repository
    )
    {
        $this->repository = $repository;
    }
    
    public function index()
    {
        try {
            $transactions = $this->repository->list();
            if(sizeof($transactions)){
                return response()->json([
                    'status' => 200,
                    'transactions'   => $transactions,
                ]);
            }
            return response()->json(['status' => 203, 'msg' => 'no record found']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function store(TransactionRequest $resquest)
    {
        try {
            $transactions = $this->repository->created($resquest->all());
            return $transactions->json();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

    }

    public function destroy($id)
    {   
        try {
            $transactions = $this->repository->deleted($id);
            return response()->json([
                'status' => 200,
                'message' => 'Transaction deleted!'
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    } 
}
