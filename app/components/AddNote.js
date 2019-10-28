import React, { Component } from 'react';
import uuid from 'uuid';
import './AddNote.css';

class AddNote extends Component {
    constructor(props) {
        super(props);
        this.state = {
            defaultColor: this.props.colors[0],
            show: false,
            text: ''
        };
        this.handleColorChange = this.handleColorChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleTextAreaChange = this.handleTextAreaChange.bind(this);
    }

    showModal() {
        this.setState({
            show: true
        });
    }

    hideModal() {
        this.setState({
            show: false
        })
    }

    handleSubmit(event) {
        event.preventDefault();
        if (this.refs.text.value === '') {
            alert('Text is required');
            return;
        }

        this.props.onCreateNote({
            id: uuid.v4(),
            color: this.refs.color.value,
            text: this.refs.text.value
        });

        this.refs.text.value = '';
        this.setState({
            text: ''
        });
    }

    handleColorChange() {
        let color = this.refs.color.value;

        this.setState({
            defaultColor: color
        });
    }

    handleTextAreaChange(e) {
        const maxLines = 9;
        const text = e.target.value;
        const lines = text.split("\n");

        if (lines.length >= maxLines) {
            return;
        }

        this.setState({
            text: text
        });
    }

    render() {
        let colors = [];
        let textAreaClasses = '';

        if (this.props.colors) {
            textAreaClasses = `note note--formatted note--handwritten note--${this.state.defaultColor}`;

            colors = this.props.colors.map((color, index) => {
                return <option key={index} value={color}>{color}</option>
            });
        }

        return (
            <div className="add-note">
                <form onSubmit={this.handleSubmit}>
                    <textarea ref="text"
                        value={this.state.text}
                        onChange={this.handleTextAreaChange}
                        className={textAreaClasses}
                        maxLength="80"
                        placeholder="Add your note text here..."
                        autoFocus="true"></textarea>
                    <div>
                        <select ref="color" onChange={this.handleColorChange}>
                            {colors}
                        </select>
                    </div>
                    <input type="submit" value="Add Note" className="add-note__submit" />
                </form>
            </div>
        );
    }
}

export default AddNote;
