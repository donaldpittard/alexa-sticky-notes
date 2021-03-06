import axios from 'axios'
import React, { Component } from 'react'

class NewNote extends Component {
    constructor(props) {
        super(props)
        this.state = {
            color: '',
            text: '',
        }

        this.handleFieldChange = this.handleFieldChange.bind(this)
        this.handleCreateNewNote = this.handleCreateNewNote.bind(this)
        this.hasError = this.hasError.bind(this)
        this.renderErrorFor = this.rednerErrorFor.bind(this)
    }

    handleFieldChange (event) {
        this.setState({
            [event.target.name]: event.target.value
        })
    }

    handleCreateNewNote (event) {
        event.preventDefault()

        const { history } = this.props

        const note = {
            color: this.state.color,
            text: this.state.text
        }
    }

    render () {
        return (
            <div className='container py-4'>
                <div className='row justify-content-center'>
                    <div className='col-md-6'>
                        <div className='card'>
                            <div className='card-header'>Create Note</div>
                            <div className='card-body'>
                                <form onSubmit={this.handleCreateNewNote}>
                                    <div className='form-group'>
                                        <label htmlFor='color'>Color</label>
                                        <select id='color'></select>
                                    </div>
                                    <div className='form-group'>
                                        <label htmlFor='text'>Text</label>
                                        <textarea 
                                            value={this.state.text}
                                            onChange={this.handleFieldChange} />
                                    </div>
                                    <button className='btn btn-primary'>Create</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default NewNote