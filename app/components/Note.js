import React from 'react';
import './Note.css';

const Note = ({ note, onDelete }) => {
    let noteClasses = `note note--handwritten note--${note.color}`;

    return (
        <div className={noteClasses}>
            <button className="note__delete-btn" onClick={() => onDelete(note.id)}>
                <i className="fa fa-minus-square" aria-hidden="true"></i>
            </button>
            <pre className="note--formatted">
                {note.text}
            </pre>
        </div>
    );
};

export default Note;
