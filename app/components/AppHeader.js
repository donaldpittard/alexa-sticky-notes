import React from 'react';
import './AppHeader.css';

const AppHeader = props => {
    return (
        <div classNameName="sticky-top d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
            <h1 className="app-brand my-0 mr-md-auto font-weight-normal">Sticky Notes</h1>
            <nav className="my-2 my-md-0 mr-md-3">
                <a className="p-2 text-dark"
                    onClick={props.onClickAddNote}
                    href="#">Add Note</a>
                <a className="p-2 text-dark"
                    onClick={props.onClickLogOut}
                    href="#">Log Out</a>
            </nav>
        </div>
    );
};

export default AppHeader;
