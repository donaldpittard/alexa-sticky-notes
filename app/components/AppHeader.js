import React from 'react';
import './AppHeader.css';

const AppHeader = props => {
    const responsive = props.showMenu ? 'header--responsive' : '';

    return (
        <nav className="header header--sticky header--shadow">
            <h1 className="header__brand">Sticky Notes</h1>
            <span className="header__icon"
                onClick={props.onClickMenu}
            >
                <i className="fa fa-bars"></i>
            </span>
            <ul className={`header__nav ${responsive}`}>
                <li>
                    <a className="header__link"
                        onClick={props.onClickAddNote}
                        href="#">Add Note</a>
                </li>
                <li>
                    <a className="header__link"
                        onClick={props.onClickLogOut}
                        href="#">Log Out</a>
                </li>
            </ul>
        </nav>
    );
};

export default AppHeader;
