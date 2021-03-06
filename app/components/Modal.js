import React from 'react';
import './Modal.css';

const Modal = ({ onClose, show, children }) => {
  const showHideClassName = show ? "modal display" : "modal display-none";

  return (
    <div className={showHideClassName}>
      <section className="modal-main">
        <div className="modal__header">
          <button className="modal-main__close-btn" onClick={onClose}>X</button>
        </div>
        {children}
      </section>
    </div>
  );
};

export default Modal;