import React, { Component } from 'react';
import './Note.css';

class Note extends Component {
    deleteNote(id) {
        this.props.onDelete(id);
    }

    render() {
        let noteClasses = `note note--handwritten note--${this.props.note.color}`;

        return (
            <div className={noteClasses}>
                <button className="note__delete-btn" onClick={this.deleteNote.bind(this, this.props.note.id)}>
                    <i className="fa fa-minus-square" aria-hidden="true"></i>
                </button>
                {this.props.note.text}
            </div>
        );
    }
}

export default Note;
