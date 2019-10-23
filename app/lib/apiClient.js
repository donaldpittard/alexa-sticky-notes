const post = (url, params) => {
    return fetch(
        url,
        {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json; charset=utf-8'
            },
            body: JSON.stringify(params)
        }
    ).then(res => res.json());
};

export const removeNote = id => post('/api/notes/remove', { id: id });
export const addNote = newNote => post('/api/notes/create', newNote);
export const fetchNotes = () => fetch('/api/notes').then(res => res.json());
