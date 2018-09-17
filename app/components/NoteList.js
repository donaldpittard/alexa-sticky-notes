import React, { Component } from 'react';
import Note from './Note';
import './NoteList.css';

class NoteList extends Component {
    deleteNote(id) {
        this.props.onDelete(id);
    }

    render() {
        let notes;

        if (this.props.notes) {
            notes = this.props.notes.map(note => {
                return (
                    <Note 
                        key={note.id} 
                        note={note} 
                        onDelete={this.deleteNote.bind(this)} />
                );
            });
        }

        return (
            <div className="note-list">
                {notes}
            </div>
        );
    }
}

export default NoteList;
