import React, { Component } from 'react';
import uuid from 'uuid';
import NoteList from './NoteList';
import AppHeader from './AppHeader';
import './App.css';

class App extends Component {
  constructor() {
    super();
    this.state = {
      notes: [],
      colors: ['red', 'orange', 'pink', 'purple', 'blue', 'cyan', 'green', 'yellow']
    };
  }

  componentDidMount() {
    fetch('/api/notes')
      .then(response => response.json())
      .then(notes => this.setState({
        'notes': notes
      }));
  }

  handleNewNote(newNote) {
    let notes = this.state.notes;
    notes.unshift(newNote);
    this.setState({notes: notes});
  }

  handleDeleteNote(id) {
    let notes = this.state.notes;
    let index = notes.findIndex(x => x.id === id);
    notes.splice(index, 1);
    this.setState({notes: notes});
  }

  render() {
    return (
      <div className="App">
        <AppHeader 
            createNote={this.handleNewNote.bind(this)} 
            colors={this.state.colors} 
            defaultColor={this.state.colors[0]} />
        <NoteList 
          onDelete={this.handleDeleteNote.bind(this)} 
          notes={this.state.notes} />
      </div>
    );
  }
}

export default App;
