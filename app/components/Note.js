import React from 'react';
import './Note.css';

const Note = ({ id, color, text, onDelete }) => {
    let noteClasses = `note note--handwritten note--${color}`;

    return (
        <div className={noteClasses}>
            <button className="note__delete-btn" onClick={() => onDelete(id)}>
                <i className="fa fa-minus-square" aria-hidden="true"></i>
            </button>
            {text}
        </div>
    );
};

export default Note;
