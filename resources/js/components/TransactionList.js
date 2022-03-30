import React, { Component } from 'react'
import { Link } from 'react-router-dom'
import axios from 'axios'

class TransactionList extends Component {
  
  state = {
    transactions: [],
    loading: true,
  }
  
  async componentDidMount(){
    const res = await axios.get('/api/transactions');
    if (res.data.status === 200){
      this.setState({
        transactions: res.data.transactions,
        loading: false,
      });
    }else{
      this.setState({
        loading: false,
      });
    }
  }

  deleteTransaction = async (e, id) => {
    const thidClickedFunda = e.currentTarget;
    thidClickedFunda.innerText = "Deleting...";

    const res = await axios.delete(`/api/transactions/${id}`);
    if(res.data.status === 200)
    {
      thidClickedFunda.closest("tr").remove()
      console.log(res.data.message);
    }
  }

  render () {
    var transaction_HTMLTABLE = "";
    if(this.state.loading){
      transaction_HTMLTABLE = <tr><center><h4>Carregando...</h4> </center></tr>
    }else{
      transaction_HTMLTABLE =
      this.state.transactions.map( (transaction) => {
        return (
          <tr key={transaction.id}>
            <td>{transaction.title}</td>
            <td>{transaction.value}</td>
            <td>{transaction.type}</td>
            <td>
              <button 
                type="button"
                className='btn btn-sm btn-danger float-right'
                onClick={(e) => this.deleteTransaction(e, transaction.id)}
                data-key={transaction.id}
              >
                Delete
              </button>
            </td>
          </tr>
        )
      });
    }
    return (
      <div className='container py-4'>
        <div className='row justify-content-center'>
          <div className='col-md-8'>
            <div className='card'>
              <div className='card-header'>All transactions</div>
              <div className='card-body'>
                <Link className='btn btn-success btn-sm mb-3' to='/create'>
                  Create new transaction
                </Link>
                <div className="card shadow">
                  <div className="card-body">
                    <table className="table datatables"> 
                      <thead>
                        <tr>
                          <th>Title</th>
                          <th>Value</th>
                          <th>Type</th>
                          <th>Ação</th>
                        </tr>
                      </thead>                  
                      <tbody>
                        {transaction_HTMLTABLE}
                      </tbody>                      
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    )
  }
}

export default TransactionList