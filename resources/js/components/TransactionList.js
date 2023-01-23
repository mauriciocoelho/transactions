import React, { Component } from 'react'
import { Link } from 'react-router-dom'
import axios from 'axios'

class TransactionList extends Component {
  
  state = {
    transactions: [],
    loading: true,
    filteredTransactions: [],
    currentPage: 1,
    transactionsPerPage: 10,
    pageNumbers: []
  }
  
  async componentDidMount() {
    const res = await axios.get('/api/v1/transactions');
    if (res.data.statuscode === 200) {
      this.setState({
        transactions: res.data.data,
        loading: false,
        filteredTransactions: res.data.data
      });
      this.updatePageNumbers();
    } else {
      this.setState({
        loading: false,
      });
    }
  }

  deleteTransaction = async (e, id) => {
    const thisClickedButton = e.currentTarget;
    thisClickedButton.innerText = "Deleting...";

    const res = await axios.delete(`/api/v1/transactions/${id}`);
    if(res.data.statuscode === 200)
    {
      thisClickedButton.closest("tr").remove()
      console.log(res.data.message);
    }
  }

  handleSearch = (event) => {
    const searchValue = event.target.value;
    const filteredTransactions = this.state.transactions.filter(transaction => {
        return transaction.title.toLowerCase().includes(searchValue.toLowerCase()) ||
               transaction.value.toString().includes(searchValue) ||
               transaction.type.toLowerCase().includes(searchValue.toLowerCase());
    });
    this.setState({ filteredTransactions });
    this.updatePageNumbers();
  }

  updatePageNumbers = () => {
    const pageNumbers = [];
    for (let i = 1; i <= Math.ceil(this.state.filteredTransactions.length / this.state.transactionsPerPage); i++) {
      pageNumbers.push(i);
    }
    this.setState({ pageNumbers });
  }

  paginate = (pageNumber) => {
    this.setState({ currentPage: pageNumber });
  }

  render() {
    const { currentPage, transactionsPerPage, transactions, filteredTransactions } = this.state;
    let transaction_HTMLTABLE = "";
    if(this.state.loading){
      transaction_HTMLTABLE = <tr><center><h4>Carregando...</h4> </center></tr>
    }else{
      const indexOfLastTransaction = currentPage * transactionsPerPage;
      const indexOfFirstTransaction = indexOfLastTransaction - transactionsPerPage;
      const currentTransactions = filteredTransactions.length>0 ? filteredTransactions.slice(indexOfFirstTransaction, indexOfLastTransaction) : transactions.slice(indexOfFirstTransaction, indexOfLastTransaction);
      
      transaction_HTMLTABLE = currentTransactions.map((transaction) => {
        return (
          <tr key={transaction.id}>
            <td>{transaction.title}</td>
            <td>{new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(transaction.value)}</td>
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
                <div className='d-flex justify-content-between'>
                  <div class="d-flex justify-content-start">
                    <Link className='btn btn-success btn-sm mb-3' to='/create'>
                      Create new transaction
                    </Link>
                  </div>
                  <div class="d-flex justify-content-end">
                    <input type='text' className='form-control mb-3' placeholder='Search...' onChange={this.handleSearch}/>
                  </div>                  
                </div>               
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
                    {this.state.transactions.length>0 && (
                      <div className="d-flex justify-content-end">
                        {this.state.pageNumbers.map(number => {
                          return (
                            <button key={number} className='btn btn-sm mx-1' onClick={() => this.paginate(number)}>{number}</button>
                          );
                        })}
                      </div>
                    )}
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