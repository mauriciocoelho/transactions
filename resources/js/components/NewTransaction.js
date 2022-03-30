import axios from 'axios'
import React, { Component } from 'react'

class NewTransaction extends Component {
  constructor (props) {
    super(props)
    this.state = {
      title: '',
      value: '',
      type: 'select',
      errors: []
    }
    this.handleFieldChange = this.handleFieldChange.bind(this)
    this.handleCreateNewTransaction = this.handleCreateNewTransaction.bind(this)
    this.hasErrorFor = this.hasErrorFor.bind(this)
    this.renderErrorFor = this.renderErrorFor.bind(this)
  }

  handleFieldChange (event) {
    this.setState({
      [event.target.name]: event.target.value
    })
  }

  handleCreateNewTransaction (event) {
    event.preventDefault()

    const { history } = this.props

    const transaction = {
      title: this.state.title,
      value: this.state.value,
      type: this.state.type
    }

    axios.post('/api/transactions', transaction)
      .then(response => {
        // redirect to the homepage
        history.push('/')
      })
      .catch(error => {
        this.setState({
          errors: error.response.data.errors
        })
    })
  }

  hasErrorFor (field) {
    return !!this.state.errors[field]
  }

  renderErrorFor (field) {
    if (this.hasErrorFor(field)) {
      return (
        <span className='invalid-feedback'>
          <strong>{this.state.errors[field][0]}</strong>
        </span>
      )
    }
  }

  render () {
    return (
        <div className='container py-4'>
            <div className='row justify-content-center'>
                <div className='col-md-6'>
                    <div className='card'>
                        <div className='card-header'>Create new transaction</div>
                        <div className='card-body'>
                            <form onSubmit={this.handleCreateNewTransaction}>
                                <div className='form-group'>
                                    <label htmlFor='title'>Title</label>
                                    <input
                                        id='title'
                                        type='text'
                                        className={`form-control ${this.hasErrorFor('title') ? 'is-invalid' : ''}`}
                                        name='title'
                                        value={this.state.title}
                                        onChange={this.handleFieldChange}
                                    />
                                    {this.renderErrorFor('title')}
                                </div>
                                <div className='form-group'>
                                    <label htmlFor='value'>Value</label>
                                    <input
                                        id='value'
                                        type='text'
                                        className={`form-control ${this.hasErrorFor('value') ? 'is-invalid' : ''}`}
                                        name='value'
                                        value={this.state.value}
                                        placeholder='$'
                                        onChange={this.handleFieldChange}
                                    />
                                    {this.renderErrorFor('value')}
                                </div>
                                <div className='form-group'>
                                    <label htmlFor='type'>Type</label>                                    
                                    <select className={`form-control ${this.hasErrorFor('type') ? 'is-invalid' : ''}`} 
                                      name='type'
                                      value={this.state.type}
                                      onChange={this.handleFieldChange}
                                    >         
                                      <option value="select">Select Type</option>
                                      <option value="income">Income</option>
                                      <option value="outcome">Outcome</option>                                    
                                    </select>                                    
                                    {this.renderErrorFor('type')}
                                </div><br></br>
                                <div className="modal-footer">                                  
                                  <a href='/' className='btn btn-primary'>Cancel</a>
                                  <button className='btn btn-success'>Save</button>
                                </div>                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
  }
}

export default NewTransaction