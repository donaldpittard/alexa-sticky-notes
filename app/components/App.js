import React, { Component } from 'react';
import { addNote, removeNote, fetchNotes } from '../lib/apiClient';
import NoteList from './NoteList';
import AppHeader from './AppHeader';
import AddNote from './AddNote';
import Modal from './Modal';
import './App.css';

class App extends Component {
  constructor() {
    super();
    this.state = {
      showAddNoteModal: false,
      notes: [],
      colors: ['red', 'orange', 'pink', 'purple', 'blue', 'cyan', 'green', 'yellow']
    };

    this.handleAddNoteClick = this.handleAddNoteClick.bind(this);
    this.handleCloseAddNoteModal = this.handleCloseAddNoteModal.bind(this);
    this.handleNewNote = this.handleNewNote.bind(this);
    this.handleDeleteNote = this.handleDeleteNote.bind(this);
  }

  async componentDidMount() {
    const notes = await fetchNotes();

    this.setState({ notes: notes });
  }

  async handleNewNote(newNote) {
    let notes = [...this.state.notes];

    addNote(newNote);
    notes.unshift(newNote);
    this.setState({ notes: notes });
  }

  async handleDeleteNote(id) {
    let notes = [...this.state.notes];
    const index = notes.findIndex(x => x.id === id);

    await removeNote(id);
    notes.splice(index, 1);
    this.setState({ notes: notes });
  }

  handleCloseAddNoteModal() {
    this.setState({ showAddNoteModal: false });
  }

  async handleLogOutClick() {
    const response = await fetch('/logout');

    document.location.href = response.url;
  }

  handleAddNoteClick() {
    this.setState({ showAddNoteModal: true });
  }

  render() {
    return (
      <div className="App">
        <AppHeader
          onClickAddNote={this.handleAddNoteClick}
          onClickLogOut={this.handleLogOutClick}
          colors={this.state.colors}
          defaultColor={this.state.colors[0]} />
        <NoteList
          onDelete={this.handleDeleteNote}
          notes={this.state.notes} />
        <Modal show={this.state.showAddNoteModal}
          onClose={this.handleCloseAddNoteModal}
        >
          <AddNote
            onCreateNote={this.handleNewNote}
            colors={this.state.colors}
            defaultColor={'red'} />
        </Modal>
      </div>
    );
  }
}

export default App;
