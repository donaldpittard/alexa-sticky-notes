import React, { Component } from 'react';
import Modal from './Modal';
import AddNote from './AddNote';
import './AppHeader.css';

class AppHeader extends Component {
    constructor(props){
        super(props);
        this.state = {
            show: false
        };
    }

    showModal() {
        this.setState({show: true});
    };

    hideModal() {
        this.setState({show: false});
    };

    createNote(newNote) {
        this.props.createNote(newNote);
        this.hideModal();
    };

    signOut() {
        fetch('/logout')
            .then(response => (document.location.href = response.url));
    };

    render() {
        return (
            <div className="app-header">
                <h1 className="app-header__title">Notes</h1>
                <button className="app-header__button" type="button" onClick={this.showModal.bind(this)}>
                    <i className="fa fa-plus-square" aria-hidden="true"></i>
                </button>
                <button className="app-header__button app-header__signout" onClick={this.signOut}>
                    <i className="fa fa-sign-out"></i>
                </button>
                <Modal show={this.state.show} handleClose={this.hideModal.bind(this)}>
                    <AddNote createNote={this.createNote.bind(this)} colors={this.props.colors} defaultColor={this.props.defaultColor} />
                </Modal>
            </div>
        );
    }
}

export default AppHeader;
