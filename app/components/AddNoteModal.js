import React, { Component } from 'react';

class AddNoteModal extends Component {
    render() {
        const showHideClassName = this.props.show ? "modal display-block" : "modal display-none";

        return (
            <div className={showHideClassName}>
                <section className="modal-main">
                    <button onClick={this.props.handleClose}>
                        Close
                    </button>
                </section>
            </div>
        );
    }
}