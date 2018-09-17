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
      colors: []
    };
  }

  componentWillMount() {
    this.setState({
      notes: [
        {
          id: uuid.v4(),
          userId: 1,
          color: "red",
          comment: "Lorem ipsum dolor sit amet, id dolor."
        },
        {
          id: uuid.v4(),
          userId: 1,
          color: "pink",
          comment: "Lorem ipsum dolor sit amet, vel ut tincidunt, tristique bibendum netus."
        },
        {
          id: uuid.v4(),
          userId: 1,
          color: "blue",
          comment: "Lorem ipsum dolor sit amet, sapien elit pulvinar."
        },
        {
          id: uuid.v4(),
          userId: 1,
          color: "green",
          comment: "Lorem ipsum dolor sit amet, suscipit ut sem."
        },
        {
          id: uuid.v4(),
          userId: 1,
          color: "orange",
          comment: "Lorem ipsum dolor sit amet, integer ac fusce."
        },
        {
          id: uuid.v4(),
          userId: 1,
          color: "yellow",
          comment: "Lorem ipsum dolor sit amet, est egestas morbi, erat quisque consequat, est pellentesque."
        },
        {
            id: uuid.v4(),
            userId: 1,
            color: "cyan",
            comment: "Lorem ipsum dolor sit amet, est egestas morbi, erat quisque consequat, est pellentesque."
        },
        {
            id: uuid.v4(),
            userId: 1,
            color: "purple",
            comment: "Lorem ipsum dolor sit amet, est egestas morbi, erat quisque consequat, est pellentesque."
        }
      ],
      colors: ['red', 'orange', 'pink', 'purple', 'blue', 'cyan', 'green', 'yellow']
    })
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
